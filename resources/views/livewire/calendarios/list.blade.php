<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\Calendario;
use App\Models\Carrera;

new class extends Component {
    public array $calendariosByDay = [];

    public function mount(): void
    {
        $this->getCalendarios();
        $this->getCarreras();
    }

    #[On('calendario-created')]
    public function getCarreras(): void
    {
        // Obtener las carreras y sus detalles, ordenadas por día de inicio
        $carreras = Carrera::query()
            ->select(['nombre', 'dia_inicio', 'num_etapas'])
            ->orderBy('dia_inicio')
            ->get();

        // Mapear las carreras para su uso en la vista y obtener día mínimo y máximo
        $this->carreras = $carreras->map(function ($carrera) {
            return [
                'nombre' => $carrera->nombre,
                'dia_inicio' => $carrera->dia_inicio,
                'num_etapas' => $carrera->num_etapas ?? 1
            ];
        })->toArray();

        // Calcular el día mínimo y máximo en función de las carreras, para determinar el rango total del calendario
        $this->diaMinimo = $carreras->min('dia_inicio');
        $this->diaMaximo = $carreras->max('dia_inicio') + $carreras->max('num_etapas') - 1;
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
};
?>

<div class="flex flex-col h-full">
    <!-- Encabezado con controles de navegación -->
    <header class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h1 class="text-base font-semibold text-gray-900">
            <time datetime="2024-11">Noviembre 2024</time>
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

<div class="relative p-8 overflow-auto rounded-xl">
    <div class="grid grid-cols-7 gap-4 font-mono text-sm font-bold leading-6 text-center text-white">
        <div class="col-span-5 p-4 bg-indigo-300 rounded-lg dark:bg-indigo-800 dark:text-indigo-400">New Zealand Cycle Classic</div>
        <div class="p-4 "></div>
        <div class="p-4 bg-indigo-300 rounded-lg dark:bg-indigo-800 dark:text-indigo-400">Clàssica C. Valenciana</div>
        <div class=""></div>
        <div class="col-span-6 p-4 bg-indigo-300 rounded-lg colspan-6 dark:bg-indigo-800 dark:text-indigo-400">Down Under</div>
    </div>
</div>





    <!-- Estructura del calendario principal -->
    <div class="flex flex-col overflow-auto bg-white">
        <!-- Cabecera de los días de la semana -->
        <div class="grid grid-cols-7 text-sm font-medium text-center text-gray-500 border-b border-gray-200">
            @for ($i = 1; $i <= 7; $i++)
                <div class="py-2">Día {{ $i }}</div>
            @endfor
        </div>

        <!-- Contenedor de eventos estructurados en filas -->
        <div class="grid grid-rows-1 gap-y-2">
            @foreach ($this->carreras as $carrera)
            {{-- <h3>{{$carrera['nombre']}}</h3> --}}


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
                        
                        <!-- Evento que ocupa columnas según la duración -->
                        <div class="col-span-{{ $duracion }} p-2 m-1 rounded-lg bg-indigo-100 text-xs font-semibold text-indigo-700">
                            {{ $carrera['nombre'] }}
                        </div>

                        <!-- Espacio vacío después del evento, si corresponde -->
                        @for ($i = $colEnd + 1; $i <= 7; $i++)
                            <div></div>
                        @endfor
                    </div>


            @endforeach
        </div>
    </div>










    <!-- Estructura del calendario principal -->
    <div class="flex flex-col overflow-auto bg-white">
        <!-- Cabecera de los días de la semana -->
        <div class="grid grid-cols-7 text-sm font-medium text-center text-gray-500 border-b border-gray-200">
            @for ($i = 1; $i <= 7; $i++)
                <div class="py-2">Día {{ $i }}</div>
            @endfor
        </div>

        <!-- Contenedor de eventos estructurados en filas -->
        <div class="grid grid-rows-1 gap-y-2">
            @foreach ($calendariosByDay as $day => $events)
                @foreach ($events as $calendario)
                    @php
                        // Determinamos el día de inicio y la duración en días
                        $diaInicio = $day;
                        $duracion = $calendario['duracion_dias'] ?? 1; // Duración en días, ejemplo de 1 día si no se especifica
                        $colEnd = $diaInicio + $duracion - 1; // Día de fin basado en la duración
                    @endphp
                    <div class="grid grid-cols-7 gap-1">
                        <!-- Espacio vacío hasta el día de inicio del evento -->
                        @for ($i = 1; $i < $diaInicio; $i++)
                            <div></div>
                        @endfor
                        
                        <!-- Evento que ocupa columnas según la duración -->
                        <div class="col-span-{{ $duracion }} p-2 m-1 rounded-lg bg-indigo-100 text-xs font-semibold text-indigo-700">
                            {{ $calendario['carrera']['nombre'] }} - Etapa {{ $calendario['etapa'] }}
                        </div>

                        <!-- Espacio vacío después del evento, si corresponde -->
                        @for ($i = $colEnd + 1; $i <= 7; $i++)
                            <div></div>
                        @endfor
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
