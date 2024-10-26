<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $ciclistas;
    public $equipo;
 
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

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y"> 

<div class="p-10">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                       {{ $equipo->nombre_equipo }}
                    </h3>                     
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr class="text-neutral-500">
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Ciclista</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Pais</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">especialidad</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">edad</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">lla</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">mon</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">col</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">cri</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">pro</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">pav</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">spr</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">acc</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">des</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">com</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">ene</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">res</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">rec</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">media</th>                                
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Puntos</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Equipo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach ($ciclistas as $ciclista)
                            <tr class="text-neutral-800">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $ciclista->apellido }}, {{ strtoupper(substr($ciclista->nombre, 0, 1)) }}.</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->pais }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->especialidad }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->edad }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->lla }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->mon }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->col }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->cri }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->pro }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->pav }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->spr }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->acc }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->des }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->com }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->ene }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->res }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->rec }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->media }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->pts }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $ciclista->equipo->nombre_equipo }}</td>
                            </tr>
                            @endforeach 

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="p-10">
    <div class="flex flex-col">
        <div x-data="{
            column: '',
            order: 'asc',
            filterU24: false,
            filterConti: false,
            sort(column) {
                if (this.column === column) {
                    this.order = this.order === 'asc' ? 'desc' : 'asc';
                } else {
                    this.column = column;
                    this.order = 'asc';
                }
            },
            sortedCiclistas() {
                let filteredData = [...{{ $ciclistas }}];

                // Aplicar filtro de corredores U24
                if (this.filterU24) {
                    filteredData = filteredData.filter(ciclista => ciclista.edad <= 24 && ciclista.media < 75);
                }

                // Aplicar filtro Conti (stats menores a 78)
                if (this.filterConti) {
                    filteredData = filteredData.filter(ciclista =>
                        ['lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com', 'ene', 'res', 'rec'].every(stat => ciclista[stat] < 78)
                    );
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
                    'ardenas': 'bg-pink-400 text-white',
                    'flandes': 'bg-yellow-300 text-white',
                    'sprinter': 'bg-green-400 text-white',
                    'escalador': 'bg-yellow-800 text-white',
                    'combatividad': 'bg-purple-800 text-white',
                    'croner': 'bg-cyan-300 text-white',
                    // Añade más categorías y colores si es necesario
                };
                return colors[especialidad.toLowerCase()] || 'bg-gray-500 text-white';
            }

        }">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ $equipo->nombre_equipo }}
                </h3> 
                <div class="flex space-x-4">

                    <div class="flex items-center">
                    <!-- Switch para activar/desactivar filtro U24 -->
                        <button
                            type="button"
                            @click="filterU24 = !filterU24"
                            :aria-checked="filterU24.toString()"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                            :class="{ 'bg-indigo-600': filterU24, 'bg-gray-200': !filterU24 }"
                            role="switch"
                            aria-labelledby="annual-billing-label"
                        >
                            <!-- Cambia la posición del círculo según el estado de `filterU24` -->
                            <span
                            aria-hidden="true"
                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            :class="{ 'translate-x-5': filterU24, 'translate-x-0': !filterU24 }"
                            ></span>
                        </button>
                    
                        <!-- Etiqueta -->
                        <span class="ml-3 text-sm" id="annual-billing-label">
                            <span class="font-medium text-gray-900">U24</span>
                        </span>
                    </div>

                    <div class="flex items-center">
                    <!-- Switch para activar/desactivar filtro Conti -->
                        <button
                            type="button"
                            @click="filterConti = !filterConti"
                            :aria-checked="filterConti.toString()"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                            :class="{ 'bg-indigo-600': filterConti, 'bg-gray-200': !filterConti }"
                            role="switch"
                            aria-labelledby="annual-billing-label"
                        >
                            <!-- Cambia la posición del círculo según el estado de `filterConti` -->
                            <span
                            aria-hidden="true"
                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                            :class="{ 'translate-x-5': filterConti, 'translate-x-0': !filterConti }"
                            ></span>
                        </button>
                    
                        <!-- Etiqueta -->
                        <span class="ml-3 text-sm" id="annual-billing-label">
                            <span class="font-medium text-gray-900">Conti .1</span>
                        </span>
                    </div>



                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead>
                        <tr>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('nombre')">Ciclista</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('pais')">País</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('especialidad')">especialidad</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('edad')">edad</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('lla')">lla</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('mon')">mon</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('col')">col</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('cri')">cri</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('pro')">pro</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('pav')">pav</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('spr')">spr</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('acc')">acc</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('des')">des</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('com')">com</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('ene')">ene</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('res')">res</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('rec')">rec</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('media')">media</th>
                            <th class="px-2 py-1.5 text-xs uppercase" @click="sort('pts')">pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="ciclista in sortedCiclistas()" :key="ciclista.id">
                            <tr class="hover:bg-slate-100">
                                <td class="px-2 py-1.5 text-xs" x-text="`${ciclista.apellido}, ${ciclista.nombre.charAt(0)}.`"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.pais"></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <span :class="getBadgeColor(ciclista.especialidad)" class="px-1.5 py-1 rounded text-xxs">
                                        <span x-text="ciclista.especialidad.slice(0, 3).toUpperCase()"></span>
                                    </span>
                                </td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.edad"></td>
                                <td class="px-2 py-1.5 text-xs">
                                    <span x-text="formatNumber(ciclista.lla).integerPart"></span><span x-text="'.' + formatNumber(ciclista.lla).decimalPart" class="text-xxs text-gray-400"></span>
                                </td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.mon"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.col"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.cri"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.pro"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.pav"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.spr"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.acc"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.des"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.com"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.ene"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.res"></td>
                                <td class="px-2 py-1.5 text-xs" x-text="ciclista.rec"></td>
                                <td class="px-2 py-1.5 text-xs font-semibold" x-text="ciclista.media"></td>
                                <td class="px-2 py-1.5 text-xs font-semibold" x-text="ciclista.pts"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
