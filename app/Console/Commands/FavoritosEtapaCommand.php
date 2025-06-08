<?php

namespace App\Console\Commands;

use App\Models\FavoritoEtapa;
use App\Services\FavoritosService;
use Illuminate\Console\Command;

class FavoritosEtapaCommand extends Command
{
    protected $signature = 'generate:favoritos
                            {temporada}
                            {num_carrera}
                            {num_etapa}
                            {--top=10}';

    protected $description = 'Genera una lista ordenada de favoritos de etapa a partir de los cod_ciclista almacenados';

    public function handle(FavoritosService $favoritosService)
    {
        $temporada   = $this->argument('temporada');
        $num_carrera = $this->argument('num_carrera');
        $num_etapa   = $this->argument('num_etapa');
        $top         = (int)$this->option('top');

        // 1) Llamo al servicio pasando cod_ciclista en lugar de id
        $similares = $favoritosService->topSimilares($temporada, $num_carrera, $num_etapa, $top);

        // 2) Formateo la salida, mostrando cod_ciclista
        $rows = [];
        foreach ($similares as $index => $c) {
            $rows[] = [
                $c->cod_ciclista,
                $index + 1,
                $c->nom_ape,
                $c->cod_equipo === 33 ? '-+ F1 +-' : $c->cod_equipo,
                ucfirst($c->especialidad),
                number_format($c->media, 2, '.', ''),
                number_format($c->score, 4, '.', ''),
                $c->temporada,
            ];
        }

        $this->table(
            ['Código','Pos.','Nombre completo','Equipo','Especialidad','Media','Score','temporada'],
            $rows
        );

        return 0;
    }
}
