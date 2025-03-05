<?php

use Livewire\Volt\Component;
use App\Models\Ciclista;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public int $numCarrera;
    public array $alineacion = [];
    public $ciclistasDisponibles;
    public ?string $mensaje = null; // Nueva variable para mostrar el mensaje

    public function mount(int $numCarrera)
    {
        $this->numCarrera = $numCarrera;
        $this->cargarCiclistas();
        $this->alineacion = array_fill(0, 8, null);
    }

    private function cargarCiclistas()
    {
        $this->ciclistasDisponibles = Ciclista::whereHas('equipo', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('nom_abrev')
            ->get();
    }

    public function mostrarAlineacion()
    {
        $this->mensaje = 'Alineación seleccionada: ' . implode(', ', array_filter($this->alineacion) ?: ['(Vacío)']);
    }
};
?>

<div class="p-4 bg-white rounded-lg shadow">
    <h2 class="mb-4 text-lg font-bold">Alineación para la carrera {{ $numCarrera }}</h2>

    <form wire:submit="mostrarAlineacion">
        @foreach(range(0, 7) as $index)
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Corredor {{ $index + 1 }}</label>
                <select wire:model="alineacion.{{ $index }}" class="w-full px-3 py-2 border rounded">
                    <option value="">(Vacío)</option>
                    @foreach($ciclistasDisponibles as $ciclista)
                        <option value="{{ $ciclista->cod_ciclista }}">{{ $ciclista->nom_abrev }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-500 rounded">
            Mostrar Alineación
        </button>

        @if($mensaje)
            <div class="p-2 mt-4 text-sm text-white bg-green-500 rounded">
                {{ $mensaje }}
            </div>
        @endif
    </form>
</div>
