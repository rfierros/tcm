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
        <div x-data="{            
            getColor(categoria) {
                const colors = {
                    'WT': 'bg-pink-600/30 text-pink-600',
                    'Conti': 'bg-yellow-400/30 text-yellow-500',
                    'U24': 'bg-green-500/30 text-green-600',
                };
                return colors[categoria] || 'bg-gray-500 text-white';
            }
        }">

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">Carreras</h3>
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">
                @foreach ($carreras as $carrera)
                <li class="flex col-span-1 rounded-md shadow-sm">
                    <!-- Usamos x-bind:class y pasamos la categoría desde el backend -->
                    <div x-bind:class="getColor('{{ $carrera->categoria }}')" 
                         class="flex items-center justify-center flex-shrink-0 w-16 text-sm font-medium rounded-l-md">
                        {{ $carrera->categoria }}
                    </div>
                    <div class="flex items-center justify-between flex-1 truncate bg-white border-t border-b border-r border-gray-200 rounded-r-md">
                        <div class="flex-1 px-4 py-2 text-sm truncate">
                            <a href="#" class="font-medium text-gray-900 hover:text-gray-600">{{ $carrera->nombre }}</a>
                            <p class="text-gray-500">{{ $carrera->tipo }} - {{ $carrera->num_etapas }} etapas</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
