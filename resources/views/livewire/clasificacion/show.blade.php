<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Equipo;

new class extends Component {
    public Collection $equipos;

    public $columns = [ // Campo => Cabecera
        'nombre_equipo' => 'Equipo',
        'total_pts' => 'Puntos',
        'num_victorias' => 'Victorias',
        'etapas_disputadas' => 'Etapas Disputadas'
    ];

    public function mount(): void
    {
        $this->cargarClasificacion();
    }

    public function cargarClasificacion(): void
    {
        $this->equipos = Equipo::hydrate(
            DB::table('resultados as r')
                ->join('equipos as e', 'r.cod_equipo', '=', 'e.cod_equipo')
                ->selectRaw('
                    e.nombre_equipo,
                    r.cod_equipo,
                    SUM(r.pts) AS total_pts,
                    COUNT(CASE WHEN r.posicion = 1 THEN 1 ELSE NULL END) AS num_victorias,
                    COUNT(DISTINCT r.num_carrera || "-" || r.etapa) AS etapas_disputadas
                ')
                ->whereBetween('r.num_carrera', [48, 56])
                ->groupBy('r.cod_equipo', 'e.nombre_equipo')
                ->orderByDesc('total_pts')
                ->get()->toArray() // Convertir a array para evitar stdClass
        );
    }
};
?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm">
    <div class="p-10">
        <div x-data="{
            column: 'total_pts',
            order: 'desc',
            sort(column) {
                this.order = (this.column === column && this.order === 'desc') ? 'asc' : 'desc';
                this.column = column;
            },
            sortedEquipos() {
                return [...{{ $equipos }}].sort((a, b) => {
                    let modifier = this.order === 'asc' ? 1 : -1;
                    return (a[this.column] < b[this.column] ? -1 : 1) * modifier;
                });
            }
        }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Clasificación de Equipos</h3>
                <button wire:click="cargarClasificacion" class="px-4 py-2 text-white bg-blue-500 rounded">
                    🔄 Actualizar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left">Pos.</th>
                            @foreach($columns as $field => $label)
                                <th class="px-4 py-2 text-left">
                                    <div class="flex items-center cursor-pointer" @click="sort('{{ $field }}')">
                                        <span>{{ $label }}</span>
                                        <span class="ml-2 text-gray-500">
                                            <template x-if="column === '{{ $field }}' && order === 'desc'">▼</template>
                                            <template x-if="column === '{{ $field }}' && order === 'asc'">▲</template>
                                        </span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(equipo, index) in sortedEquipos()" :key="equipo.cod_equipo">
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2" x-text="index + 1"></td>
                                <td class="px-4 py-2" x-text="equipo.nombre_equipo"></td>
                                <td class="px-4 py-2 text-right" x-text="equipo.total_pts.toFixed(4)"></td>
                                <td class="px-4 py-2 text-center" x-text="equipo.num_victorias"></td>
                                <td class="px-4 py-2 text-center" x-text="equipo.etapas_disputadas"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
