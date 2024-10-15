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


</div>
