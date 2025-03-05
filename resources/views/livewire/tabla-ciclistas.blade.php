<?php

use Livewire\Volt\Component;
use App\Models\Ciclista;

new class extends Component
{
    public ?int $equipoId = null;
    public ?int $numCarrera = null; // Nueva propiedad para filtrar por carrera
    public bool $soloAsignados = false;
    public bool $soloLibres = false;

    public function mount(?int $equipoId = null, ?int $numCarrera = null, bool $soloAsignados = false, bool $soloLibres = false)
    {
        $this->equipoId = $equipoId;
        $this->numCarrera = $numCarrera; // Guardar la carrera si se proporciona
        $this->soloAsignados = $soloAsignados;
        $this->soloLibres = $soloLibres;
    }

    public function ciclistas()
    {
        $query = Ciclista::query()
            ->with('equipo');

        if ($this->numCarrera) {
            // 🔹 Filtramos ciclistas que participaron en la carrera
            $query->whereHas('resultados', function ($q) {
                $q->where('num_carrera', $this->numCarrera);
            })
            ->with(['resultados' => function ($q) {
                $q->where('num_carrera', $this->numCarrera);
            }])
            // 🔹 Filtramos la suma de puntos solo para la carrera específica
            ->withSum(['resultados as pts_carrera' => function ($q) {
                $q->where('num_carrera', $this->numCarrera);
            }], 'pts');
        } else {
            // 🔹 Si no hay carrera, sumamos todos los puntos
            $query->withSum('resultados', 'pts');
        }

        if ($this->equipoId) {
            $query->where('cod_equipo', $this->equipoId);
        }

        if ($this->soloAsignados) {
            $query->whereNotNull('cod_equipo');
        }

        if ($this->soloLibres) {
            $query->whereNull('cod_equipo');
        }

        $ciclistas = $query->get();

        // 🔹 Ordenamos manualmente si es clasificación de carrera
        if ($this->numCarrera) {
            return $ciclistas->sortBy(fn($c) => $c->resultados->first()->pos_gral ?? PHP_INT_MAX);
        }

        return $ciclistas;
    }

};
?>
<div>
    <button wire:click="$refresh" class="px-4 py-2 mb-2 text-white bg-blue-500 rounded">
        Actualizar
    </button>

    @if ($this->ciclistas()->isNotEmpty())
        <table class="w-full border border-collapse border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Nombre</th>
                    <th class="px-4 py-2 border">Equipo</th>
                    <th class="px-4 py-2 border">Puntos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->ciclistas() as $ciclista)
                    <tr>
                        <td class="px-4 py-2 border">{{ $ciclista->nom_abrev }}</td>
                        <td class="px-4 py-2 border">{{ $ciclista->equipo->nombre_equipo ?? 'Sin equipo' }}</td>
                        <td class="px-4 py-2 border">{{ number_format($ciclista->resultados_sum_pts, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-gray-500">No hay ciclistas para mostrar.</p>
    @endif
</div>
