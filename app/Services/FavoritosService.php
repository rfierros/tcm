<?php

namespace App\Services;

use App\Models\Ciclista;
use App\Models\Carrera;
use App\Models\FavoritoEtapa;
use Illuminate\Support\Facades\Log;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;

class FavoritosService
{
    /**
     * Devuelve ciclistas inscritos filtrados por temporada, categoría y otros criterios.
     */
    public function obtenerLista2(Carrera $carrera)
    {
        $cat = strtolower(trim($carrera->categoria));
        $temporada = $carrera->temporada;

        $query = Ciclista::where('temporada', $temporada)
                         ->whereNotNull('cod_equipo')
                         ->whereHas('inscripciones', fn($q) =>
                             $q->where('temporada', $temporada)
                               ->where('num_carrera', $carrera->num_carrera)
                         );

        if ($cat === 'u24') {
            $query->where('es_u24', true);
        } elseif ($cat === 'conti') {
            $query->where('es_conti', true);
        } elseif ($cat === 'pro') {
            $query->where('es_pro', true);
        }

        Log::info("SQL: " . $query->toSql(), $query->getBindings());
        return $query->get();
    }

    /**
     * Genera ranking topN, seleccionando dinámicamente características relevantes
     * basadas en la variación/importancia en la lista de favoritos.
     */
    public function topSimilares(int $temporada, int $num_carrera, int $num_etapa, int $topN = 20)
    {
        // 1) Cargar carrera y favoritos
        $carrera = Carrera::where(compact('temporada','num_carrera'))->firstOrFail();
        $favRow  = FavoritoEtapa::where(compact('temporada','num_carrera','num_etapa'))->firstOrFail();

        $listaFav = array_filter([
            $favRow->fav1, $favRow->fav2, $favRow->fav3, $favRow->fav4,
            $favRow->fav5, $favRow->fav6, $favRow->fav7, $favRow->fav8,
            $favRow->fav9, $favRow->fav10, $favRow->fav11,
        ], fn($c) => !is_null($c));

        // 2) Obtener candidatos
        $lista2 = $this->obtenerLista2($carrera);
        if ($lista2->isEmpty()) {
            return collect();
        }

        // 3) Cargar modelos de favoritos
        $favModels = Ciclista::whereIn('cod_ciclista',$listaFav)
                              ->where('temporada',$temporada)
                              ->get()
                              ->keyBy('cod_ciclista');
        $lista1 = array_values(array_map(fn($c)=> $favModels->get($c), $listaFav));
        $m = count($lista1);
        if ($m < 2) {
            return $lista2->sortByDesc('media')->take($topN);
        }

        // 4) Definir características numéricas y one-hot specs
        $numerics = ['lla','mon','col','cri','pro','pav','spr','acc','des','com','ene','res','rec','media'];
        $allSpecs = Ciclista::distinct()->pluck('especialidad')->sort()->values()->toArray();

        // 5) Calcular importancia de cada numérico en favoritos
        $importance = [];
        foreach ($numerics as $col) {
            $sum = 0;
            foreach ($lista1 as $c) {
                $sum += abs((float)$c->{$col});
            }
            $importance[$col] = $sum;
        }
        arsort($importance);
        // Seleccionar top K características (ej. K=6)
        $K = 6;
        $selectedNums = array_slice(array_keys($importance),0,$K);

        // 6) Estadísticas de lista2 para solo las seleccionadas
        list($means,$stds) = $this->calcStats($lista2,$selectedNums);

        // 7) Construir vectores estandarizados para lista1 sobre seleccionadas
        $X1_num = []; $X1_spec = [];
        $specIdx = array_flip($allSpecs);
        foreach ($lista1 as $c) {
            $row = [];
            foreach ($selectedNums as $col) {
                $row[] = ((float)$c->{$col} - $means[$col]) / $stds[$col];
            }
            $X1_num[] = $row;
            // one-hot spec
            $oh = array_fill(0,count($allSpecs),0.0);
            $oh[$specIdx[$c->especialidad]] = 1.0;
            $X1_spec[] = $oh;
        }

        // 8) Preparar lista2 matrices
        list($X2_num,$X2_spec,$vals2) = $this->prepareList2($lista2,$selectedNums,$allSpecs,$means,$stds);
        $n = count($vals2);

        // 9) Pesos bloques favoritos
        $weights = [];
        for ($i=0;$i<$m;$i++){
            if ($i<4)      { $weights[$i]=0.6/min($m,4); }
            elseif ($i<8)  { $cnt=min($m,8)-4; $weights[$i]= $cnt?0.3/$cnt:0; }
            else           { $cnt=max(0,$m-8);   $weights[$i]= $cnt?0.1/$cnt:0; }
        }

        // 10) Prototipo
        $q = count($selectedNums);
        $S = count($allSpecs);
        $proto_num = array_fill(0,$q,0.0);
        $proto_spec= array_fill(0,$S,0.0);
        for($i=0;$i<$m;$i++){
            for($j=0;$j<$q;$j++){ $proto_num[$j]+=$weights[$i]*$X1_num[$i][$j]; }
            for($t=0;$t<$S;$t++){ $proto_spec[$t]+=$weights[$i]*$X1_spec[$i][$t]; }
        }

        // 11) Calcular distancias
        $cands = [];
        for($i=0;$i<$n;$i++){
            $sum2=0;
            for($j=0;$j<$q;$j++){ $d=$X2_num[$i][$j]-$proto_num[$j]; $sum2+=$d*$d; }
            for($t=0;$t<$S;$t++){ $d=$X2_spec[$i][$t]-$proto_spec[$t]; $sum2+=$d*$d; }
            $c = $vals2[$i];
            $c->score = sqrt($sum2);
            $cands[] = $c;
        }

        // 12) Ordenar por score y devolver
        return collect($cands)->sortBy('score')->values()->take($topN);
    }

    private function calcStats($list2,array $cols):array
    {
        $n = $list2->count();
        $means=[]; $stds=[];
        foreach($cols as $col){
            $vals = $list2->pluck($col)->map(fn($v)=>(float)$v)->all();
            $mean = array_sum($vals)/$n; $means[$col]=$mean;
            $sum2=0; foreach($vals as $v){$d=$v-$mean; $sum2+=$d*$d;}            
            $stds[$col]=sqrt($sum2/$n)?:1.0;
        }
        return [$means,$stds];
    }

    private function prepareList2($list2,array $cols,array $specs,array $means,array $stds):array
    {
        $n = $list2->count(); $q=count($cols); $S=count($specs);
        $vals2 = $list2->values();
        $X2_num = array_fill(0,$n,array_fill(0,$q,0));
        $X2_spec= array_fill(0,$n,array_fill(0,$S,0));
        $specIdx=array_flip($specs);
        for($i=0;$i<$n;$i++){
            $c = $vals2[$i];
            for($j=0;$j<$q;$j++){ $col=$cols[$j];
                $X2_num[$i][$j]=((float)$c->{$col}-$means[$col])/$stds[$col];
            }
            $e=$c->especialidad; if(isset($specIdx[$e])) $X2_spec[$i][$specIdx[$e]]=1;
        }
        return [$X2_num,$X2_spec,$vals2];
    }
}
