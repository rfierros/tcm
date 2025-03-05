<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Resultado;
use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $equipos;
    public Collection $ciclistas;
    public $equipo;

    public $columns = [ // Campo => Cabecera
        'nombre_equipo' => 'Equipo',
        'total_pts' => 'Puntos',
        'num_victorias' => 'Victorias',
        'victorias_vueltas' => 'Vueltas',
//        'etapas_disputadas' => 'Etapas Disputadas',
    ];

    public $botones = [ // Campo => Cabecera
        'WT' => 'WT',
        'Conti' => 'Conti .1',
    ];
 
    public function mount(): void
    {
        $this->cargarClasificacion(); 
    }

    #[On('equipo-created')]
    public function cargarClasificacion(): void
    {
        $this->equipos = Equipo::hydrate(
            DB::table('resultados as r')
                ->join('equipos as e', 'r.cod_equipo', '=', 'e.cod_equipo')
                ->leftJoin('carreras as c', function ($join) {
                    $join->on('r.num_carrera', '=', 'c.num_carrera')
                         ->on('r.temporada', '=', 'c.temporada')
                         ->where('c.num_etapas', '>', 1); // 🔹 Solo vueltas
                })
                ->selectRaw('
                    e.nombre_equipo,
                    e.categoria,
                    r.cod_equipo,
                    SUM(r.pts) AS total_pts,
                    COUNT(CASE WHEN r.posicion = 1 THEN 1 ELSE NULL END) AS num_victorias,
                    COUNT(DISTINCT r.num_carrera || "-" || r.etapa) AS etapas_disputadas,
                    COUNT(DISTINCT CASE 
                        WHEN c.num_etapas IS NOT NULL 
                        AND r.etapa = c.num_etapas 
                        AND r.pos_gral = 1 
                        THEN r.num_carrera 
                        ELSE NULL 
                    END) AS victorias_vueltas
                ')
                ->where('r.num_carrera', '>', 0)
                ->groupBy('r.cod_equipo', 'e.nombre_equipo')
                ->orderByDesc('total_pts')
                ->get()->toArray() // Convertir a array para evitar stdClass
        );
    }
    
 
}; ?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm"> 

<div class="p-10">
    <div class="flex flex-col">
        <div x-data="{
            equipos: {{ json_encode($equipos) }},
            column: '',
            order: 'asc',
            selectedFilter: 'WT',  // Valor inicial para mostrar todos los registros
            sort(column, order) {
                this.column = column;
                this.order = order;
            },
            sortedEquipos() {
                let filteredData = [...this.equipos];

                // Aplicar filtros en base al valor de selectedFilter
                if (this.selectedFilter === 'Conti') {
                    filteredData = filteredData.filter(equipo => equipo.conti);
                }

                return filteredData.sort((a, b) => {
                    let modifier = this.order === 'asc' ? 1 : -1;
                    if (a[this.column] < b[this.column]) return -1 * modifier;
                    if (a[this.column] > b[this.column]) return 1 * modifier;
                    return 0;
                });
            },
            formatNumber(value) {
                const [integerPart, decimalPart] = value.toFixed(2).split('.');
                return { integerPart, decimalPart };
            },
            getCategoryColor(cat) {
                const colors = {
                    'wt': 'bg-sky-600 font-bold text-white',
                    'conti': 'bg-green-400/70 font-bold',
                };
                return colors[cat.toLowerCase()] || 'bg-white';
            }
        }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">
                    Clasificación General
                </h3> 

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead>
                        <tr>
                            <th class="px-2 py-1.5 text-xs leading-none text-left">Pos.</th>
                            @foreach($columns as $column => $label)
                                <th class="px-2 py-1.5 text-xs leading-none uppercase">
                                    <div class="flex items-center space-x-2">
                                        <span @click="sort('{{ $column }}', order === 'asc' ? 'desc' : 'asc')" class="cursor-pointer">
                                            {{ $label }}
                                        </span>
                                        <div class="flex flex-col text-gray-400">
                                            <span @click="sort('{{ $column }}', 'desc')" class="leading-none cursor-pointer">˄</span>
                                            <span @click="sort('{{ $column }}', 'asc')" class="leading-none cursor-pointer">˅</span>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(equipo, index) in sortedEquipos()" :key="equipo.cod_equipo">
                            
                            <tr :class="getCategoryColor(equipo.categoria)"  class="hover:bg-slate-100 hover:text-gray-800">
                                <td class="px-2 py-1.5 text-md" x-text="index + 1"></td>
                                <template x-for="(label, field) in {{ json_encode($columns) }}" :key="field">
                                    <td class="px-2 py-1.5 text-md">
                                        <template x-if="['total_pts'].includes(field)">
                                            <span>
                                                <span x-text="formatNumber(equipo[field]).integerPart"></span>
                                                <span x-text="'.' + formatNumber(equipo[field]).decimalPart"></span>
                                            </span>
                                        </template>
                                        <template x-if="!['total_pts'].includes(field)">
                                            <span x-text="equipo[field]"></span>
                                        </template>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
