<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $equipos;
 
    public function mount(): void
    {
        // $this->equipos = Equipo::with('user') 
        //     ->latest()
        //     ->get(); 
        $this->getEquipos(); 
    }
 
    // Si se crea un Equipo hay un listener para el evento de creacion que actualizará la lista de Equipos
    #[On('equipo-created')]
    public function getEquipos(): void
    {
        $temporada = config('tcm.temporada');

        // Filtrar las carreras por la temporada actual
        $this->equipos = Equipo::where('temporada', $temporada)
            ->orderBy('nombre_equipo')
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
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Equipo</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Manager</th>
                                <th class="px-5 py-3 text-xs font-medium text-left uppercase">Puntos</th>
                                <th class="px-5 py-3 text-xs font-medium text-right uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach ($equipos as $equipo)
                            <tr class="text-neutral-800">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $equipo->nombre_equipo }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $equipo->user->name ?? 'Usuario no asignado' }}</td>
                                <td class="px-5 py-4 text-sm whitespace-nowrap">2300</td>
                                <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a class="text-blue-600 hover:text-blue-700" href="#">Edit</a>
                                </td>
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
