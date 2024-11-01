<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\Calendario;

new class extends Component {
    public array $calendariosByDay = [];

    public function mount(): void
    {
        $this->getCalendarios();
    }

    #[On('calendario-created')]
    public function getCalendarios(): void
    {
        // Obtener todos los registros de calendario y agruparlos por día en un array
        $this->calendariosByDay = Calendario::with('carrera')
            ->orderBy('dia')
            ->get()
            ->groupBy('dia')
            ->toArray(); // Convertimos la colección en un array
    }
};
?>

<div class="p-10 mt-6 bg-white rounded-lg shadow-sm">
    <h1 class="mb-6 text-2xl font-bold">Calendario de Carreras</h1>
    <table class="min-w-full border border-neutral-200">
        <thead>
            <tr class="bg-neutral-50">
                @for ($i = 1; $i <= 7; $i++)
                    <th class="px-4 py-2 text-xs font-medium text-left uppercase text-neutral-500">Día {{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php
                $day = 1;
            @endphp
            @while ($day <= max(array_keys($calendariosByDay)))
                <tr class="divide-x divide-neutral-200">
                    @for ($i = 0; $i < 7; $i++)
                        <td class="px-4 py-3 text-sm align-top border-t text-neutral-800">
                            @if (isset($calendariosByDay[$day]))
                                @foreach ($calendariosByDay[$day] as $calendario)
                                    <div>{{ $calendario['carrera']['nombre'] }} {{ $calendario['etapa'] }}</div>
                                @endforeach
                            @endif
                            @php $day++ @endphp
                        </td>
                    @endfor
                </tr>
            @endwhile
        </tbody>
    </table>
</div>
