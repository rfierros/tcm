<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Carrera;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $carreras;
 
    public function mount(): void
    {
        $this->getCarreras(); 
    }
 
    // Si se crea una Carrera, hay un listener para el evento de creación que actualizará la lista de Carreras
    #[On('carrera-created')]
    public function getCarreras(): void
    {
      $this->carreras = Carrera::orderBy('dia_inicio')->orderBy('bloque')->orderBy('id')->get();
    } 
}; 
?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm"> 
    <div class="p-10">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden border rounded-lg">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr class="text-neutral-500">
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Nombre</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Categoría</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Tipo</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Temporada</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Día de Inicio</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">N° de Etapas</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-right uppercase">Semana</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @foreach ($carreras as $carrera)
                                <tr class="text-neutral-800">
                                    <td class="px-2 py-1.5 text-sm font-medium whitespace-nowrap"><a href="{{ route('etapas.index', $carrera->id) }}">{{ $carrera->nombre }}</a></td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $carrera->categoria }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $carrera->tipo }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $carrera->temporada }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $carrera->dia_inicio }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $carrera->num_etapas }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $carrera->bloque }}</td>
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