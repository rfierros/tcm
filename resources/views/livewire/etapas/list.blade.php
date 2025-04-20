<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Carrera;
use App\Models\Etapa;
use App\Models\Resultado;
use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Carrera $carrera;
    public Collection $etapas;
    public string $slugCarrera;
    public Collection $ciclistas;
    public Collection $allCiclistas;
 
    public function mount(): void
    {
        $this->getCarrera(); 
        $this->getEtapas(); 
        $this->getInscripciones();
        $this->getAllInscripciones();
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

    public function getInscripciones(): void
    {
        $equipo = Equipo::where('user_id', Auth::id())->first();
        
        if (!$equipo) {
            $this->ciclistas = collect(); // Si no hay equipo, devolvemos una colección vacía
            return;
        }

        $this->ciclistas = Ciclista::whereHas('resultados', function ($query) use ($equipo) {
            $query->where('etapa', 1)
                ->where('num_carrera', $this->carrera->num_carrera)
                ->where('temporada', $this->carrera->temporada)
                ->where('cod_equipo', $equipo->cod_equipo); 
        })->get();
    }

    public function getAllInscripciones(): void
    {
        $equipo = Equipo::where('user_id', Auth::id())->first();
        
        if (!$equipo) {
            $this->ciclistas = collect(); // Si no hay equipo, devolvemos una colección vacía
            return;
        }
        
        // $this->allCiclistas = Ciclista::whereHas('resultados', function ($query) {
        //     $query->where('etapa', 1)
        //         ->where('num_carrera', $this->carrera->num_carrera)
        //         ->where('temporada', $this->carrera->temporada);
        // })
        // ->with(['equipo', 'resultados' => function ($query) {
        //     $query->where('etapa', 1)
        //         ->where('num_carrera', $this->carrera->num_carrera)
        //         ->where('temporada', $this->carrera->temporada);
        // }])
        // ->orderBy('cod_equipo')
        // ->get();

        $this->allCiclistas = Ciclista::whereHas('inscripciones', function ($query) use ($equipo) {
            $query->where('num_carrera', $this->carrera->num_carrera)
                  ->where('temporada', $this->carrera->temporada)
                    ->where(function ($q) {
                        $q->where('sancion', '!=', 'd')
                            ->orWhereNull('sancion'); // 🔹 Incluir valores NULL
                    });
            })
            ->with([
                'equipo',
                'inscripciones' => function ($query) {
                    $query->where('num_carrera', $this->carrera->num_carrera)
                        ->where('temporada', $this->carrera->temporada)
                        ->select('cod_ciclista', 'forma', 'sancion');
                }
            ])
            ->orderBy('cod_equipo')
            ->get();


        // Clasificar ciclistas según el tiempo en los resultados
        // $this->allCiclistas->each(function ($ciclista) {
        //     $resultado = $ciclista->resultados->first();
        //     $ciclista->hasTiempoD = $resultado && $resultado->tiempo === 'd';
        // });
    }


}
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
            },
            getColorTipo(perfil) {
                const colors = {
                    'cri': 'bg-blue-50 text-blue-600 ring-blue-500/10',
                    'cre': 'bg-indigo-50 text-indigo-800 ring-indigo-600/20',
                };
                return colors[perfil] || 'bg-pink-100 text-pink-600 ring-pink-500/10';
            },
            getColorPaves(perfil) {
                const colors = {
                    '1': 'bg-green-50 text-green-600 ring-green-500/10',
                    '2': 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                    '3': 'bg-yellow-100 text-yellow-800 ring-yellow-600/20',
                    '4': 'bg-blue-100 text-red-700 ring-red-600/10',
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
                            <span x-bind:class="getColor(@js($etapa->nombre))" class="inline-flex items-center justify-center w-10 h-10 text-xs rounded-lg">
                                {{ $etapa->num_etapa }} 
                            </span>
                        </div>
                    
                        <span class="flex-1 block min-w-0">
                            <span class="block text-sm font-medium text-gray-900 truncate">{{ $etapa->nombre }}</span>
                            <span class="block text-sm font-medium text-gray-500 truncate">
                                <span x-bind:class="getColor('{{ $etapa->perfil }}')" class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                    {{ $etapa->perfil }}
                                </span>
                                - {{ $etapa->km }}km -

                                @if ($etapa->tipo !== 'normal')
                                    <span x-bind:class="getColorTipo('{{ $etapa->tipo }}')" class="inline-flex items-center p-1 text-xs font-medium rounded-md ring-1 ring-inset">
                                        @if ($etapa->tipo == 'cri')
                                            <x-icons.cri class="w-3 h-3" />
                                        @endif
                                        @if ($etapa->tipo == 'cre')
                                            <x-icons.cre class="w-3 h-3" />
                                        @endif
                                    </span>
                                @endif

                                @if ($etapa->paves != 0)
                                    <span x-bind:class="getColorPaves('{{ $etapa->paves }}')" class="inline-flex items-center p-1 text-xs font-medium rounded-md ring-1 ring-inset">
                                        <!-- Ejemplo: icono "badge-check" para pavés -->
                                        <x-icons.paves class="w-3 h-3" />
                                    </span>
                                @endif
                            </span>
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
            formatNumber(value) {
                const [integerPart, decimalPart] = value.toFixed(2).split('.');
                return { integerPart, decimalPart };
            },
            getBadgeColor(especialidad) {
                const colors = {
                    'ardenas': 'bg-pink-600/30 text-pink-600',
                    'flandes': 'bg-yellow-400/30 text-yellow-500',
                    'sprinter': 'bg-green-500/30 text-green-600',
                    'escalador': 'bg-yellow-800/30 text-yellow-800',
                    'combatividad': 'bg-purple-800/30 text-purple-800',
                    'croner': 'bg-cyan-400/30 text-cyan-600',
                };
                return colors[especialidad.toLowerCase()] || 'bg-gray-500 text-white';
            }            
        }">

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">Inscripciones</h3>
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">

                @foreach ($ciclistas as $ciclista)
                <li>
                    <div class="flex items-center justify-between w-full p-2 space-x-3 text-left border border-gray-300 rounded-lg shadow-sm group hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex items-center flex-1 min-w-0 space-x-3">
                        <span class="flex-1 block min-w-0">
                            <span class="block text-sm font-medium text-gray-900 truncate">{{ $ciclista->nom_abrev }}</span>
                            <span class="block text-sm font-medium text-gray-500 truncate"><span x-bind:class="getBadgeColor('{{ $ciclista->especialidad }}')" class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium">{{ $ciclista->especialidad }}</span> - <span class="text-xxs">{{ $ciclista->media }}</span></span>
                        </span>
                    </span>
                    </div>
                </li>      
                @endforeach
            </ul>
        
        </div>
    </div>


    <div class="p-10">
        <div x-data="{            
            formatNumber(value) {
                const [integerPart, decimalPart] = value.toFixed(2).split('.');
                return { integerPart, decimalPart };
            },
            getBadgeColor(especialidad) {
                const colors = {
                    'ardenas': 'bg-pink-600/30 text-pink-600',
                    'flandes': 'bg-yellow-400/30 text-yellow-500',
                    'sprinter': 'bg-green-500/30 text-green-600',
                    'escalador': 'bg-yellow-800/30 text-yellow-800',
                    'combatividad': 'bg-purple-800/30 text-purple-800',
                    'croner': 'bg-cyan-400/30 text-cyan-600',
                };
                return colors[especialidad.toLowerCase()] || 'bg-gray-500 text-white';
            }            
        }">

            <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">Inscripciones</h3>
            <ul role="list" class="grid grid-cols-1 gap-5 mt-3 sm:grid-cols-2 sm:gap-6 md:grid-cols-3 xl:grid-cols-4">

        
            @foreach ($allCiclistas->groupBy('equipo.nombre_equipo') as $equipoNombre => $ciclistas)
                <div class="mt-8 team-group ">
                    <h3 class="mb-4 font-semibold leading-tight text-gray-800">{{ $equipoNombre ?? 'Sin equipo' }}</h3>
                    <ul>
                        @foreach ($ciclistas as $ciclista)
                            <li>
                                @if ($ciclista->hasTiempoD)
                                <div class="flex items-center justify-between w-full p-0.5 space-x-3 text-left bg-red-300 border border-gray-300 rounded-lg shadow-sm group hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                @else
                                <div class="flex items-center justify-between w-full p-0.5 space-x-3 text-left border border-gray-300 rounded-lg shadow-sm group hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                @endif
                                <span class="flex items-center flex-1 min-w-0 space-x-3">
                                    <span class="flex-1 block min-w-0">
                                        <span class="block text-sm font-medium text-gray-900 truncate">{{ $ciclista->nom_abrev }}</span>
                                        <span class="block text-sm font-medium text-gray-500 truncate"><span x-bind:class="getBadgeColor('{{ $ciclista->especialidad }}')" class="inline-flex items-center rounded-md px-1.5 py-0.5 text-xs font-medium">{{ $ciclista->especialidad }}</span> - <span class="text-xxs">{{ number_format($ciclista->media, 2) }}</span> - <span class="text-xxs">{{ number_format(optional($ciclista->inscripciones->first())->forma ?? 0, 2) }}</span></span>
                                    </span>
                                </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            </ul>
        
        </div>
    </div>



</div>
