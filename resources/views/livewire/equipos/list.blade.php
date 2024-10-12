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
        $this->equipos = Equipo::with('user')
            ->latest()
            ->get();
    } 
}; ?>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y"> 
    @foreach ($equipos as $equipo)
        <div class="p-6 flex space-x-2" wire:key="{{ $equipo->id }}">
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-800">{{ $equipo->nombre_equipo }}</span>
                        
                    </div>
                </div>
            </div>
        </div>
    @endforeach 
</div>
