<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Ciclista;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $ciclistas;
 
    public function mount(): void
    {
        // $this->ciclistas = Ciclista::with('user') 
        //     ->latest()
        //     ->get(); 
        $this->getCiclistas(); 
    }
 
    // Si se crea un Ciclista hay un listener para el evento de creacion que actualizará la lista de Ciclistas
    #[On('ciclista-created')]
    public function getCiclistas(): void
    {
        $this->ciclistas = Ciclista::with('equipo.user')
            ->latest()
            ->get();
    } 
}; ?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm"> 

<div class="p-10">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full">
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr class="text-neutral-500">
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Ciclista</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Pais</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">especialidad</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">edad</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">lla</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">mon</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">col</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">cri</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">pro</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">pav</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">spr</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">acc</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">des</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">com</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">ene</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">res</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">rec</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">media</th>                                
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Puntos</th>
                                <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Equipo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach ($ciclistas as $ciclista)
                            <tr class="text-neutral-800">
                                <td class="px-2 py-1.5 text-xs font-medium whitespace-nowrap">{{ $ciclista->apellido }}, {{ strtoupper(substr($ciclista->nombre, 0, 1)) }}.</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->pais }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->especialidad }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->edad }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->lla }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->mon }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->col }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->cri }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->pro }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->pav }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->spr }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->acc }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->des }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->com }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->ene }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->res }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->rec }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->media }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->pts }}</td>
                                <td class="px-2 py-1.5 text-xs whitespace-nowrap">{{ $ciclista->equipo->nombre_equipo }}</td>
                            </tr>
                            @endforeach 

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<div class="bg-green-50">
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
                filteredData = filteredData.filter(ciclista => ciclista.edad <= 24);
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
        }
    }">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-lg font-bold">Mi tabla</h1>
            <div class="flex space-x-2">
                <!-- Botón para activar/desactivar el filtro U24 -->
                <button
                    class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                    :class="{ 'bg-blue-700': filterU24 }"
                    @click="filterU24 = !filterU24"
                >
                    U24
                </button>
                <!-- Botón para activar/desactivar el filtro Conti -->
                <button
                    class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600"
                    :class="{ 'bg-green-700': filterConti }"
                    @click="filterConti = !filterConti"
                >
                    Conti
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead>
                    <tr>
                        <th class="px-2 py-1.5 text-xs" @click="sort('nombre')">Ciclista</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('pais')">País</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('especialidad')">especialidad</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('edad')">edad</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('lla')">lla</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('mon')">mon</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('col')">col</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('cri')">cri</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('pro')">pro</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('pav')">pav</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('spr')">spr</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('acc')">acc</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('des')">des</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('com')">com</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('ene')">ene</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('res')">res</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('rec')">rec</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('media')">media</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('pts')">pts</th>
                        <th class="px-2 py-1.5 text-xs" @click="sort('equipo->nombre_equipo')">Equipo</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="ciclista in sortedCiclistas()" :key="ciclista.id">
                        <tr>
                            <td class="px-2 py-1.5 text-xs" x-text="`${ciclista.apellido}, ${ciclista.nombre.charAt(0)}.`"></td>
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.pais"></td>
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.especialidad"></td>
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.edad"></td>
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.lla"></td>
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
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.media"></td>
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.pts"></td>
                            <td class="px-2 py-1.5 text-xs" x-text="ciclista.equipo->nombre_equipo"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>




    </div>
</div>


</div>
