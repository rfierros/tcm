<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\Calendario;
use App\Models\Carrera;

new class extends Component {
    public array $calendariosByDay = [];
    public int $diaMinimo = 0;
    public int $diaMaximo = 0;

    public function mount(): void
    {
        $this->getCalendarios();
        $this->getCarreras();
        $this->getMaxDiaInicio();

    }

    #[On('calendario-created')]
    public function getCarreras(): void
    {
        // Obtener las carreras y sus detalles, ordenadas por día de inicio
        $carreras = Carrera::query()
            ->select(['nombre', 'dia_inicio', 'num_etapas', 'categoria', 'tipo'])
            ->orderBy('dia_inicio')
            ->get();

        // Mapear las carreras para la vista y calcular el rango de días
        $this->carreras = $carreras->map(function ($carrera) {
            return [
                'nombre' => $carrera->nombre,
                'dia_inicio' => $carrera->dia_inicio,
                'num_etapas' => $carrera->num_etapas ?? 1,
                'categoria' => $carrera->categoria,
                'tipo' => $carrera->tipo,
                'colorClass' => $this->getColorClass($carrera->nombre, $carrera->categoria, $carrera->tipo)
            ];
        })->toArray();

        // Calcular el día mínimo y máximo en función de las carreras, para determinar el rango total del calendario
        $this->diaMinimo = $carreras->min('dia_inicio');
        $this->diaMaximo = $carreras->max('dia_inicio') + $carreras->max('num_etapas') - 1;
    }

    private function getColorClass(string $nombre, string $categoria, string $tipo): string
    {
        // Mapa de colores para combinaciones de categoría y tipo
        $colorMap = [
            'WT-Vuelta' => 'bg-gray-300 text-gray-700',
            'WT-Clasica' => 'bg-sky-400 text-sky-900',
            'Conti-Clasica' => 'bg-amber-700 text-amber-950',
            'Conti-Vuelta' => 'bg-green-200 text-green-900',
            'U24-Vuelta' => 'bg-green-500 text-green-900',
            'U24-Clasica' => 'bg-stone-700 text-white',
            'WT-Monumento' => 'bg-blue-100 text-blue-700',
            'WT-GV' => 'bg-teal-100 text-teal-700'
        ];

        // Colores específicos para cada una de las Grandes Vueltas
        $gvColors = [
            'Giro de Italia' => 'bg-pink-200 text-pink-900',
            'Tour de Francia' => 'bg-yellow-200 text-yellow-900',
            'Vuelta a España' => 'bg-red-200 text-red-900'
        ];

        // Comprobar si el tipo es "GV" y asignar color específico si es una de las tres grandes vueltas
        if ($tipo === 'GV' && array_key_exists($nombre, $gvColors)) {
            return $gvColors[$nombre];
        }

        // Generar la clave para el mapa de colores generales y devolver la clase correspondiente o una clase por defecto
        $key = "{$categoria}-{$tipo}";
        return $colorMap[$key] ?? 'bg-indigo-100 text-indigo-700';
    }

    #[On('calendario-created')]
    public function getCalendarios(): void
    {
        // Obtener y agrupar los eventos de calendario por día
        $this->calendariosByDay = Calendario::with('carrera')
            ->orderBy('dia')
            ->get()
            ->groupBy('dia')
            ->toArray();
    }
public function getMaxDiaInicio(): int
{
    // Obtiene el valor máximo de la columna 'dia_inicio' de la tabla 'carreras'
    return Carrera::max('dia_inicio');
}
};
?>

<div class="flex flex-col h-full bg-pink-700">
    <!-- Encabezado con controles de navegación -->
    <header class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h1 class="text-base font-semibold text-gray-900">
            <time datetime="2024-11">DPRRRUUUEBA</time>
        </h1>
        <div class="flex items-center"> 
            <div class="relative flex items-center bg-white rounded-md shadow-sm">
                <button type="button" class="flex items-center justify-center w-12 text-gray-400 border-l border-gray-300 h-9 rounded-l-md border-y hover:text-gray-500 focus:relative">
                    <span class="sr-only">Semana Anterior</span>
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" /></svg>
                </button>
                <button type="button" class="border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50">Hoy</button>
                <button type="button" class="flex items-center justify-center w-12 text-gray-400 border-r border-gray-300 h-9 rounded-r-md border-y hover:text-gray-500 focus:relative">
                    <span class="sr-only">Semana Siguiente</span>
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" /></svg>
                </button>
            </div>
        </div>
    </header>

<div class="flex flex-col h-full overflow-x-auto">
    <!-- Cabecera de los días con flexbox -->
    <div class="flex text-sm font-medium text-center text-gray-500 border-b border-gray-200">
        @for ($dia = $diaMinimo; $dia <= $diaMaximo; $dia++)
            <div class="py-2 min-w-[35px] bg-gray-100">{{ $dia }}</div>
        @endfor
    </div>

    <!-- Filas de carreras con flexbox -->
    @foreach ($this->carreras as $carrera)
        @php
            $colStart = $carrera['dia_inicio'] - $diaMinimo;  // Calcular el día de inicio relativo
            $colSpan = $carrera['num_etapas']; // Número de días o etapas
        @endphp

        <!-- Carrera con clase de color dinámica según categoría y tipo -->
        <div class="p-4 m-1 min-w-[35px] rounded-lg text-xs font-semibold {{ $carrera['colorClass'] }}"
             style="margin-left: {{ $colStart * 35 }}px; width: {{ $colSpan * 35 }}px;">
            {{ $carrera['nombre'] }} ({{ $carrera['num_etapas'] }} días)
        </div>
    @endforeach
</div>



<div class="p-2 mt-6 bg-white rounded-lg shadow-sm">
    <h1 class="mb-6 text-2xl font-bold">Calendario de Carreras</h1>
    <div class="flex gap-2 overflow-x-auto">
        @foreach ($calendariosByDay as $day => $carreras)
            <div class="flex-1 min-w-[150px] border border-neutral-200 rounded-lg p-1">
                <h2 class="text-xs font-medium text-center uppercase text-neutral-500">Día {{ $day }}</h2>
                <div class="mt-4 space-y-2">
                    @foreach ($carreras as $carrera)
                        {{-- @if ($carrera['etapa'] == 1) --}}
                        <div class="p-2 rounded-lg bg-neutral-100 ">
                            <strong>{{ $carrera['carrera']['nombre'] }}</strong> - Etapa {{ $carrera['etapa'] }}
                        </div>
                        {{-- @endif --}}
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>






    <div class="flex flex-col overflow-auto bg-white">
        <!-- Cabecera de los días de la semana -->
        {{-- <div class="grid grid-cols-7 text-sm font-medium text-center text-gray-500 border-b border-gray-200">
            @for ($i = 1; $i <= 7; $i++)
                <div class="py-2">Día {{ $i }}</div>
            @endfor
        </div> --}}

        <!-- Contenedor de eventos estructurados en filas -->
        <div class="grid grid-rows-1 gap-y-2">
            @foreach ($this->carreras as $carrera)

                    @php
                        // Determinamos el día de inicio y la duración en días
                        $diaInicio = $carrera['dia_inicio'];
                        $duracion = $carrera['num_etapas'] ?? 1; // Duración en días, ejemplo de 1 día si no se especifica
                        $colEnd = $diaInicio + $duracion - 1; // Día de fin basado en la duración
                    @endphp
                    <div class="grid grid-cols-7 gap-1">
                        <!-- Espacio vacío hasta el día de inicio del evento -->
                        @for ($i = 1; $i < $diaInicio; $i++)
                            <div></div>
                        @endfor

                        <!-- Carrera con clase de color dinámica según categoría y tipo -->
                        <div class="col-span-{{ $duracion }} p-4 m-1 rounded-lg text-xs font-semibold {{ $carrera['colorClass'] }}">
                            {{ $carrera['nombre'] }} ({{ $carrera['num_etapas'] }})
                        </div>                        

                        <!-- Espacio vacío después del evento, si corresponde -->
                        @for ($i = $colEnd + 1; $i <= 7; $i++)
                            <div></div>
                        @endfor
                    </div>


            @endforeach
        </div>
    </div>



</div>



