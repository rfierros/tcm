<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Carrera;
use App\Models\Etapa;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Carrera $carrera;
    public Collection $etapas;
    public string $slugCarrera;
 
    public function mount(): void
    {
        $this->getCarrera(); 
        $this->getEtapas(); 
    }
 
    // Si se crea una Carrera, hay un listener para el evento de creación que actualizará la lista de Carreras
    #[On('carrera-created')]
    public function getCarrera(): void
    {
        $temporada = config('tcm.temporada');

        // Filtrar las carreras por la temporada actual
        $this->carrera = Carrera::where('temporada', $temporada)
            ->where('slug',$this->slugCarrera)
            ->firstOrFail();

            // dd($this->carrera);
    } 
    public function getEtapas(): void
    {
        $temporada = config('tcm.temporada');

        // Filtrar las carreras por la temporada actual
        $this->etapas = Etapa::where('temporada', $temporada)
            ->where('slug',$this->slugCarrera)
            ->orderBy('num_etapa')
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

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">{{ $carrera->nombre }}</h3>
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">
                @foreach ($etapas as $etapa)
                <li>
                    <a href="{{ route('etapas', $etapa->slug) }}" class="flex items-center justify-between w-full p-2 space-x-3 text-left border border-gray-300 rounded-lg shadow-sm group hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex items-center flex-1 min-w-0 space-x-3">
                        <div class="flex-shrink-0">
                            <span x-bind:class="getColor('{{ $etapa->categoria }}')" class="inline-flex items-center justify-center w-10 h-10 text-xs rounded-lg">
                                {{ $etapa->num_etapa }} 
                            </span>
                        </div>
                    
                        <span class="flex-1 block min-w-0">
                        <span class="block text-sm font-medium text-gray-900 truncate">Nombre Etapa{{ $etapa->dia }}</span>
                        <span class="block text-sm font-medium text-gray-500 truncate">{{ $etapa->perfil }} 123km</span>
                        </span>
                    </span>
                    </a>
                </li>                
                @endforeach
            </ul>

        </div>
    </div>
</div>
