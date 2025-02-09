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
        'categoria' => 'Categoria',
        'nombre_equipo' => 'Equipo',
        'total_pts' => 'Puntos',
        'num_victorias' => 'Victorias',
        'etapas_disputadas' => 'Etapas Disputadas'
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
                ->selectRaw('
                    e.nombre_equipo,
                    e.categoria,
                    r.cod_equipo,
                    SUM(r.pts) AS total_pts,
                    COUNT(CASE WHEN r.posicion = 1 THEN 1 ELSE NULL END) AS num_victorias,
                    COUNT(DISTINCT r.num_carrera || "-" || r.etapa) AS etapas_disputadas
                ')
                ->where('r.num_carrera', '>', 0)
                ->groupBy('r.cod_equipo', 'e.nombre_equipo')
                ->orderByDesc('total_pts')
                ->get()->toArray() // Convertir a array para evitar stdClass
        );
//$this->equipos = Equipo::withCount([
//        'resultados as total_pts' => function ($query) {
//            $query->select(DB::raw('SUM(pts)'));
//        },
//        'resultados as num_victorias' => function ($query) {
//            $query->where('posicion', 1);
//        },
//        'resultados as etapas_disputadas' => function ($query) {
//            $query->select(DB::raw('COUNT(DISTINCT num_carrera || "-" || etapa)'));
//        }
//    ])
//    ->whereHas('resultados', function ($query) {
//        $query->where('num_carrera', '>', 0);
//    })
//    ->orderByDesc('total_pts')
//    ->get();

        //dd($this->equipos);
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
            getBadgeColor(especialidad) {
                const colors = {
                    'ardenas': 'bg-pink-600/30 text-pink-600',
                    'flandes': 'bg-yellow-400/30 text-yellow-500',
                    'sprinter': 'bg-green-500/30 text-green-600',
                    'escalador': 'bg-yellow-800/30 text-yellow-800',
                    'combatividad': 'bg-purple-800/30 text-purple-800',
                    'croner': 'bg-cyan-400/30 text-cyan-600',
                };
                return colors[especialidad.toLowerCase()] || 'bg-gray-500 text-white';
            }
        }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">
                    Clasificación
                </h3> 
                <div class="flex space-x-4">
                    <fieldset aria-label="Choose a filter option">
                        <div class="grid grid-cols-3 gap-3 mt-2 mb-1 sm:grid-cols-6">
                            @foreach($botones as $boton => $label)
                                <label :class="{
                                    'bg-indigo-600 text-white hover:bg-indigo-500 ring-0': selectedFilter === '{{ $boton }}',
                                    'ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50': selectedFilter !== '{{ $boton }}'
                                }" class="flex items-center justify-center px-3 py-3 text-sm font-semibold uppercase rounded-md cursor-pointer focus:outline-none sm:flex-1">
                                    <input type="radio" name="filter-option" value="{{ $boton }}" class="sr-only" @click="selectedFilter = '{{ $boton }}'">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                            <label :class="{
                                'bg-indigo-600 text-white hover:bg-indigo-500 ring-0': selectedFilter === 'U24',
                                'ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50': selectedFilter !== 'U24'
                            }" class="flex items-center justify-center px-3 py-3 text-sm font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer focus:outline-none sm:flex-1 ring-1 ring-gray-300 hover:bg-gray-50">
                                <input type="radio" name="filter-option" value="colores" class="sr-only" @click="selectedFilter = 'U24'">
                                <span>Colores</span>
                            </label>
                                <div>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'ard'" name="filter-option" class="sr-only" @click="selectedFilter = 'ard'">
                                            <span x-text="'ard'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'cro'" name="filter-option" class="sr-only" @click="selectedFilter = 'cro'">
                                            <span x-text="'cro'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'esc'" name="filter-option" class="sr-only" @click="selectedFilter = 'esc'">
                                            <span x-text="'esc'"></span>
                                        </label>
                                </div>
                                <div>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'spr'" name="filter-option" class="sr-only" @click="selectedFilter = 'spr'">
                                            <span x-text="'spr'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'com'" name="filter-option" class="sr-only" @click="selectedFilter = 'com'">
                                            <span x-text="'com'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'fla'" name="filter-option" class="sr-only" @click="selectedFilter = 'fla'">
                                            <span x-text="'fla'"></span>
                                        </label>
                                </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead>
                        <tr>
                            @foreach($columns as $column => $label)
                                <th class="px-2 py-1.5 text-xxs leading-none uppercase">
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
<template x-for="equipo in sortedEquipos()" :key="equipo.cod_equipo">
    <tr class="hover:bg-slate-100">
        <template x-for="(label, field) in {{ json_encode($columns) }}" :key="field">
            <td class="px-2 py-1.5 text-xs">
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
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
