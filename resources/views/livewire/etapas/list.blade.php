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
            getColor(perfil) {
                const colors = {
                    'llano': 'bg-green-50 text-green-600 ring-green-500/10',
                    'media-montaña': 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                    'montaña': 'bg-red-50 text-red-700 ring-red-600/10',
                };
                return colors[perfil] || 'bg-pink-100 text-pink-600 ring-pink-500/10';
            }
        }">

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">{{ $carrera->nombre }}</h3>
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">
                @foreach ($etapas as $etapa)
                <li>

                    <a href="{{ route('etapas', $etapa->slug) }}" class="flex items-center justify-between w-full p-2 space-x-3 text-left border border-gray-300 rounded-lg shadow-sm group hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex items-center flex-1 min-w-0 space-x-3">
                        <div class="flex-shrink-0">
                            <span x-bind:class="getColor('{{ $etapa->nombre }}')" class="inline-flex items-center justify-center w-10 h-10 text-xs rounded-lg">
                                {{ $etapa->num_etapa }} 
                            </span>
                        </div>
                    
                        <span class="flex-1 block min-w-0">
                        <span class="block text-sm font-medium text-gray-900 truncate">{{ $etapa->nombre }}</span>
                        <span class="block text-sm font-medium text-gray-500 truncate"><span x-bind:class="getColor('{{ $etapa->perfil }}')" class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">{{ $etapa->perfil }}</span> - {{ $etapa->km }}km</span>
                        
                        </span>
                    </span>
                    </a>
                </li>                
                @endforeach
            </ul>
  
        </div>
    </div>
    <div class="p-10">
        <div x-data="{            
            getColor(perfil) {
                const colors = {
                    'llano': 'bg-green-50 text-green-600 ring-green-500/10',
                    'media-montaña': 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                    'montaña': 'bg-red-50 text-red-700 ring-red-600/10',
                };
                return colors[perfil] || 'bg-pink-100 text-pink-600 ring-pink-500/10';
            }
        }">

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">Inscripciones</h3>
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">
                @foreach ($etapas as $etapa)
                <li>
                    <a href="{{ route('etapas', ['carrera' => $carrera->slug, 'etapa' => $etapa->id]) }}">Ver Etapa</a>

                    <a href="{{ route('etapas', $etapa->slug) }}" class="flex items-center justify-between w-full p-2 space-x-3 text-left border border-gray-300 rounded-lg shadow-sm group hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex items-center flex-1 min-w-0 space-x-3">
                        <div class="flex-shrink-0">
                            <span x-bind:class="getColor('{{ $etapa->nombre }}')" class="inline-flex items-center justify-center w-10 h-10 text-xs rounded-lg">
                                {{ $etapa->num_etapa }} 
                            </span>
                        </div>
                    
                        <span class="flex-1 block min-w-0">
                        <span class="block text-sm font-medium text-gray-900 truncate">{{ $etapa->nombre }}</span>
                        <span class="block text-sm font-medium text-gray-500 truncate"><span x-bind:class="getColor('{{ $etapa->perfil }}')" class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">{{ $etapa->perfil }}</span> - {{ $etapa->km }}km</span>
                        
                        </span>
                    </span>
                    </a>
                </li>                
                @endforeach
            </ul>
        
        </div>
    </div>
</div>
