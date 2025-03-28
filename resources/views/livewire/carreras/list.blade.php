<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Carrera;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $carreras;

    public $botones = [ // Campo => Cabecera
        'WT' => 'WT',
        'Conti' => 'Conti .1',
        'U24' => 'U24',
    ];
 
    public function mount(): void
    {
        $this->getCarreras(); 
    }
 
    // Si se crea una Carrera, hay un listener para el evento de creación que actualizará la lista de Carreras
    #[On('carrera-created')]
    public function getCarreras(): void
    {
        $temporada = config('tcm.temporada');

        // Filtrar las carreras por la temporada actual
        $this->carreras = Carrera::where('temporada', $temporada)
            ->orderBy('dia_inicio')
            ->orderBy('bloque')
            ->orderBy('id')
            ->get();
    } 
}; 
?>




<div class="mt-6 bg-white divide-y rounded-lg shadow-sm"> 
    <div class="p-10">
        <div x-data="{            
            getColor(categoria) {
                const colors = {
                    'WT': 'bg-sky-600/30 text-sky-600',
                    'Conti': 'bg-amber-400/30 text-amber-500',
                    'U24': 'bg-stone-500/30 text-stone-600',
                };
                return colors[categoria] || 'bg-gray-500 text-white';
            }
        }">

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">Carreras</h3>
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



                        </div>
                    </fieldset>
            </div>
                                
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">
                @foreach ($carreras as $carrera)
                <li>
                    <a href="{{ route('etapas', $carrera->slug) }}" class="flex items-center justify-between w-full p-2 space-x-3 text-left border border-gray-300 rounded-lg shadow-sm group hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex items-center flex-1 min-w-0 space-x-3">
                        <div class="flex-shrink-0">
                            <span x-bind:class="getColor('{{ $carrera->categoria }}')" class="inline-flex items-center justify-center w-10 h-10 text-xs rounded-lg">
                                {{ $carrera->categoria }}
                            </span>
                        </div>
                    
                        <span class="flex-1 block min-w-0">
                        <span class="block text-sm font-medium text-gray-900 truncate">{{ $carrera->num_carrera }}. {{ $carrera->nombre }}</span>
                        <span class="block text-sm font-medium text-gray-500 truncate">{{ $carrera->tipo }} {{ $carrera->num_etapas > 1 ? '- ' . $carrera->num_etapas . ' etapas' : '' }}</span>
                        </span>
                    </span>
                    </a>
                </li>                
                @endforeach
            </ul>

        </div>
    </div>
</div>
