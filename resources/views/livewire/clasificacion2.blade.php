<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Equipo;

new class extends Component {
    public Collection $equipos;
    public int $inicioCarrera = 54;
    public int $finCarrera = 57;

    public $columns = [ 
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
        // 🔹 Recupera todos los resultados y filtra en JS (más eficiente en frontend)
        $this->equipos = Equipo::hydrate(
            DB::table('resultados as r')
                ->join('equipos as e', 'r.cod_equipo', '=', 'e.cod_equipo')
                ->selectRaw('
                    e.nombre_equipo,
                    r.cod_equipo,
                    r.num_carrera, 
                    SUM(r.pts) AS total_pts,
                    COUNT(CASE WHEN r.posicion = 1 THEN 1 ELSE NULL END) AS num_victorias,
                    COUNT(DISTINCT r.num_carrera || "-" || r.etapa) AS etapas_disputadas
                ')
                ->groupBy('r.cod_equipo', 'e.nombre_equipo', 'r.num_carrera')
                ->orderByDesc('total_pts')
                ->get()->toArray()
        );
    }
};
?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm">
    <div class="p-0">
        <div x-data="{
            equipos: {{ json_encode($equipos) }},
            inicioCarrera: 54,
            finCarrera: 57,
            column: 'total_pts',
            order: 'desc',

            checkRango() {
                if (this.inicioCarrera > this.finCarrera) {
                    this.finCarrera = this.inicioCarrera;
                } else if (this.finCarrera < this.inicioCarrera) {
                    this.inicioCarrera = this.finCarrera;
                }
            },

            filteredEquipos() {
                return this.equipos
                    .filter(equipo => equipo.num_carrera >= this.inicioCarrera && equipo.num_carrera <= this.finCarrera)
                    .reduce((acc, equipo) => {
                        let key = equipo.cod_equipo;
                        if (!acc[key]) {
                            acc[key] = { ...equipo };
                        } else {
                            acc[key].total_pts += equipo.total_pts;
                            acc[key].num_victorias += equipo.num_victorias;
                            acc[key].etapas_disputadas += equipo.etapas_disputadas;
                        }
                        return acc;
                    }, {});
            },

            sortedEquipos() {
                return Object.values(this.filteredEquipos()).sort((a, b) => {
                    let modifier = this.order === 'asc' ? 1 : -1;
                    return (a[this.column] < b[this.column] ? -1 : 1) * modifier;
                });
            }
        }" x-init="$watch('inicioCarrera', () => checkRango()); $watch('finCarrera', () => checkRango());">
            
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Clasificación de Equipos</h3>
                <div class="flex gap-4">
                    <div>
                        <label for="inicio" class="block text-sm font-medium text-gray-700">Carrera Inicio</label>
                        <input type="number" id="inicio" x-model="inicioCarrera" class="w-20 p-1 border rounded">
                    </div>
                    <div>
                        <label for="fin" class="block text-sm font-medium text-gray-700">Carrera Fin</label>
                        <input type="number" id="fin" x-model="finCarrera" class="w-20 p-1 border rounded">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-1 text-left">Pos.</th>
                            <th class="px-4 py-1 text-left">
                                <div class="flex items-center cursor-pointer" @click="column = 'nombre_equipo'">
                                    <span>Equipo</span>
                                </div>
                            </th>
                            <th class="px-4 py-1 text-left">
                                <div class="flex items-center cursor-pointer" @click="column = 'total_pts'">
                                    <span>Puntos</span>
                                </div>
                            </th>
                            <th class="px-4 py-1 text-left">
                                <div class="flex items-center cursor-pointer" @click="column = 'num_victorias'">
                                    <span>Victorias</span>
                                </div>
                            </th>
                            <th class="px-4 py-1 text-left">
                                <div class="flex items-center cursor-pointer" @click="column = 'etapas_disputadas'">
                                    <span>Etapas Disputadas</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(equipo, index) in sortedEquipos()" :key="equipo.cod_equipo">
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-1" x-text="index + 1"></td>
                                <td class="px-4 py-1" x-text="equipo.nombre_equipo"></td>
                                <td class="px-4 py-1 text-right" x-text="equipo.total_pts.toFixed(4)"></td>
                                <td class="px-4 py-1 text-center" x-text="equipo.num_victorias"></td>
                                <td class="px-4 py-1 text-center" x-text="equipo.etapas_disputadas"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
