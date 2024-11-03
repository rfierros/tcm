<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $ciclistas;
    public $equipo;

    public $columns = [ // Campo => Cabecera
        'apellido' => 'Ciclista',
        'pais' => 'pais',
        'especialidad' => 'tipo',
        'edad' => 'edad',
        'lla' => 'lla',
        'mon' => 'mon',
        'col' => 'col',
        'cri' => 'cri',
        'pro' => 'pro',
        'pav' => 'pav',
        'spr' => 'spr',
        'acc' => 'acc',
        'des' => 'des',
        'com' => 'com',
        'ene' => 'ene',
        'res' => 'res',
        'rec' => 'rec',
        'media' => 'media',
        'pts' => 'pts',
    ];

    public $botones = [ // Campo => Cabecera
        'WT' => 'WT',
        'Conti' => 'Conti .1',
        'U24' => 'U24',
    ];
 
    public function mount(): void
    {
        // $this->ciclistas = Ciclista::with('user') 
        //     ->latest()
        //     ->get(); 
        $this->getMyCiclistas(); 
        $this->equipo = Equipo::where('user_id', Auth::id())->first();
    }
 
    // Si se crea un Ciclista hay un listener para el evento de creacion que actualizará la lista de Ciclistas
    #[On('ciclista-created')]
    public function getMyCiclistas(): void
    {
        $this->ciclistas = Ciclista::whereHas('equipo', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->with('equipo.user') // Esto carga los equipos y usuarios asociados
        ->latest()
        ->get();
    } 
}; ?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm"> 



<div class="p-10">
    <div class="flex flex-col">
        <div x-data="{
            column: '',
            order: 'asc',
            selectedFilter: 'WT',  // Valor inicial para mostrar todos los registros
            sort(column, order) {
                this.column = column;
                this.order = order;
            },
            sortedCiclistas() {
                let filteredData = [...{{ $ciclistas }}];

                // Aplicar filtros en base al valor de selectedFilter
                if (this.selectedFilter === 'U24') {
                    filteredData = filteredData.filter(ciclista => ciclista.u24);
                } else if (this.selectedFilter === 'Conti') {
                    filteredData = filteredData.filter(ciclista => ciclista.conti);
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
                    {{ $equipo->nombre_equipo }}
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
                        <template x-for="ciclista in sortedCiclistas()" :key="ciclista.id">
                            <tr class="hover:bg-slate-100">
                                <template x-for="(label, field) in {{ json_encode($columns) }}" :key="field">
                                    <td x:class="{ 'bg-red-200': colorMode }" class="px-2 py-1.5 text-xs">
                                        <template x-if="['lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com', 'ene', 'res', 'rec', 'media'].includes(field)">
                                            <span>
                                                <span x-text="formatNumber(ciclista[field]).integerPart" class="text-xs"></span><span x-text="'.' + formatNumber(ciclista[field]).decimalPart" class="inline-block text-gray-400 text-xxs"></span>
                                            </span>
                                        </template>
                                        <template x-if="['especialidad'].includes(field)">
                                                <span :class="getBadgeColor(ciclista.especialidad)" class="px-1 py-0.5 rounded text-xxs">
                                                    <span x-text="ciclista.especialidad.slice(0, 3).toUpperCase()"></span>
                                                </span>
                                            
                                        </template>
                                        <template x-if="!['especialidad', 'lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com', 'ene', 'res', 'rec', 'media'].includes(field)">
                                            <span x-text="ciclista[field]"></span>
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
