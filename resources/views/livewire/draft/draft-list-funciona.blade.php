<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On; 
use App\Models\Inscripcion;
use App\Models\Ciclista;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Collection; 

new class extends Component {
    public Collection $ciclistas;
    public $equipo;

    public $columns = [ // Campo => Cabecera
        'nom_abrev' => 'Ciclista',
        'cod_ciclista' => 'Id',
        'especialidad' => 'tipo',
        'edad' => 'edad',
        'lla' => 'lla',
        'mon' => 'mon',
        'col' => 'col',
        'cri' => 'cri',
        'pro' => 'pro',
        'pav' => 'pav',
        'spr' => 'spr',
        'acc' => 'acc',
        'des' => 'des',
        'com' => 'com',
        'ene' => 'ene',
        'res' => 'res',
        'rec' => 'rec',
        'media' => 'media',
        'total_puntos' => 'pts',
        'inscripciones' => 'Insc.',
    ];

    public $botones = [ // Campo => Cabecera
        'WT' => 'WT',
        'Conti' => 'Conti .1',
        'U24' => 'U24',
    ];

public function ficharCiclista()
{
    if ($this->selectedCiclista) {
        // Obtener el equipo del usuario autenticado
        $equipo = Equipo::where('user_id', Auth::id())->first();

        if ($equipo) {
            // Actualizar el ciclista en la base de datos
            Ciclista::where('cod_ciclista', $this->selectedCiclista['cod_ciclista'])
                ->where('temporada', $this->selectedCiclista['temporada'])
                ->update(['cod_equipo' => $equipo->cod_equipo]);

            $this->dispatch('reset-seleccion');
            $this->dispatch('actualizar-ciclistas');

            // Mensaje de confirmación
            session()->flash('message', "El ciclista {$this->selectedCiclista['nom_abrev']} ha sido añadido al equipo {$equipo->nombre_equipo}.");

            // Cerrar modal y resetear selección
            $this->dispatch('close-modal', 'confirm-draft-selection');
            $this->reset('selectedCiclista');
        }
    }
}


public $selectedCiclista;

public function setSelectedCiclista($id)
{
    $this->selectedCiclista = $this->ciclistas->firstWhere('cod_ciclista', (int) $id);
}



    public function mount(): void
    {
        $this->getMyCiclistas(); 
        $this->equipo = Equipo::where('user_id', Auth::id())->first();
    }
 
    // Si se crea un Ciclista hay un listener para el evento de creacion que actualizará la lista de Ciclistas
    #[On('actualizar-ciclistas')]
    public function getMyCiclistas(): void
    {
        // $temporada = config('tcm.temporada');
        $temporada = 5;

        $this->ciclistas = Ciclista::where('temporada', 5)
            ->where('draft', 'u24')
            ->where('pos_draft', null)
            ->orderBy('media', 'desc')
            ->get();
    }

}; ?>

<div class="mt-6 bg-white rounded-lg shadow-sm"> 



<x-modal name="confirm-draft-selection" focusable>
    <form wire:submit.prevent="ficharCiclista">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Selección de Draft
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                ¿Quieres seleccionar a este ciclista?
            </p>

            @if ($selectedCiclista)
            <div class="p-4 mt-4 bg-gray-100 border border-gray-300 rounded-md">
                <h3 class="text-lg font-semibold text-gray-900">{{ $selectedCiclista->nom_abrev }}</h3>
                <p class="text-sm text-gray-700">Especialidad: <x-badge :tipo="$selectedCiclista->especialidad" /> <strong>{{ ucfirst($selectedCiclista->especialidad) }}</strong></p>
                <p class="text-sm text-gray-700">Edad: <strong>{{ $selectedCiclista->edad }}</strong></p>

                <!-- Grid con dos columnas -->
                <div class="grid grid-cols-2 mt-3 gap-x-6">
                    <p class="text-sm text-gray-700 uppercase">LLA: <strong>{{ number_format($selectedCiclista->lla, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">MON: <strong>{{ number_format($selectedCiclista->mon, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">COL: <strong>{{ number_format($selectedCiclista->col, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">CRI: <strong>{{ number_format($selectedCiclista->cri, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">PRO: <strong>{{ number_format($selectedCiclista->pro, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">PAV: <strong>{{ number_format($selectedCiclista->pav, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">SPR: <strong>{{ number_format($selectedCiclista->spr, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">ACC: <strong>{{ number_format($selectedCiclista->acc, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">DES: <strong>{{ number_format($selectedCiclista->des, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">COM: <strong>{{ number_format($selectedCiclista->com, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">ENE: <strong>{{ number_format($selectedCiclista->ene, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">RES: <strong>{{ number_format($selectedCiclista->res, 2) }}</strong></p>
                    <p class="text-sm text-gray-700 uppercase">REC: <strong>{{ number_format($selectedCiclista->rec, 2) }}</strong></p>
                </div>

                <p class="mt-3 text-sm text-gray-700">Media: <strong>{{ number_format($selectedCiclista->media, 2) }}</strong></p>
            </div>

            @endif

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button type="submit" class="ms-3">
                    Seleccionar
                </x-danger-button>
            </div>
        </div>
    </form>
</x-modal>


@if (session()->has('message'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        class="p-4 mt-4 text-green-600 bg-green-100 border border-green-400 rounded-md">
        {{ session('message') }}
    </div>
@endif
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('reset-seleccion', () => {
            document.querySelectorAll('input[name="selected_ciclista"]').forEach(input => {
                input.checked = false; // Desmarca todos los radio buttons
            });
        });
    });
</script>
<div class="px-4 sm:px-6 lg:px-8">
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">  
      <h1 class="text-base font-semibold text-gray-900">Draft U24</h1>
      <p class="mt-2 text-sm text-gray-700">Corredores seleccionables.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
      <button type="button" wire:click="$dispatch('open-modal', 'confirm-draft-selection')" class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Seleccionar</button>
    </div>
  </div>
  <div class="flow-root mt-8">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-1 align-middle sm:px-6 lg:px-8">
        <div class="relative">
          <!-- Selected row actions, only show when rows are selected. -->
          <!-- <div class="absolute top-0 flex items-center h-12 space-x-3 bg-white left-14 sm:left-12"> -->
          <!--   <button type="button" class="inline-flex items-center px-2 py-1 text-sm font-semibold text-gray-900 bg-white rounded shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">Bulk edit</button> -->
          <!--   <button type="button" class="inline-flex items-center px-2 py-1 text-sm font-semibold text-gray-900 bg-white rounded shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">Delete all</button> -->
          <!-- </div> -->

          <table class="min-w-full divide-y divide-gray-300 table-fixed">
            <thead>
              <tr>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 capitalize">Eq.</th>
                <th scope="col" class="relative px-7 sm:w-12 sm:px-6">                </th>
                <th scope="col" class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900 capitalize">Nombre</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 capitalize">tipo</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 capitalize">edad</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">lla</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">mon</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">col</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">cri</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">pro</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">pav</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">spr</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">acc</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">des</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">com</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">ene</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">res</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 uppercase">rec</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 capitalize">media</th>
              </tr>
            </thead>
<tbody class="bg-white divide-y divide-gray-200">
@foreach($ciclistas as $ciclista)
<tr 
    x-data
    x-init="$el.addEventListener('click', () => {
        if ({{ $ciclista->cod_equipo ? 'false' : 'true' }}) {
            $wire.setSelectedCiclista({{ $ciclista->cod_ciclista }});
        }
    })"
    :class="{
        'cursor-pointer hover:bg-blue-100': {{ $ciclista->cod_equipo ? 'false' : 'true' }},
        'cursor-not-allowed bg-gray-100 text-gray-300': {{ $ciclista->cod_equipo ? 'true' : 'false' }}
    }"
>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">
        <x-team-badge :tipo="$ciclista->cod_equipo" />
    </td>
    <td class="relative px-7 sm:w-12 sm:px-6">
        @if(empty($ciclista->cod_equipo))
        <div class="absolute grid grid-cols-1 -mt-2 group left-4 top-1/2 size-4">
            <input  
                type="radio" 
                name="selected_ciclista"
                wire:model="selectedCiclista"
                value="{{ $ciclista->cod_ciclista }}"
                x-on:click.stop
            >
        </div>
        @endif
    </td>
    <td class="py-0.5 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $ciclista->nom_abrev }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">
        <x-badge :tipo="$ciclista->especialidad" />
    </td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->edad }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->lla }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->mon }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->col }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->cri }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->pro }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->pav }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->spr }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->acc }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->des }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->com }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->ene }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->res }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->rec }}</td>
    <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap">{{ $ciclista->media }}</td>
</tr>
@endforeach
</tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>




<div class="p-2">
    <div class="flex flex-col">
        <div x-data="{
            column: '',
            order: 'asc',
            selectedFilter: 'WT',  // Valor inicial para mostrar todos los registros
            sort(column, order) {
                this.column = column;
                this.order = order;
            },
            sortedCiclistas() {
                let filteredData = [...{{ $ciclistas }}];

                // Aplicar filtros en base al valor de selectedFilter
                if (this.selectedFilter === 'U24') {
                    filteredData = filteredData.filter(ciclista => ciclista.es_u24);
                } else if (this.selectedFilter === 'Conti') {
                    filteredData = filteredData.filter(ciclista => ciclista.es_conti);
                }

                return filteredData.sort((a, b) => {
                    let modifier = this.order === 'asc' ? 1 : -1;
                    if (a[this.column] < b[this.column]) return -1 * modifier;
                    if (a[this.column] > b[this.column]) return 1 * modifier;
                    return 0;
                });
            },
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
                    'combativo': 'bg-purple-800/30 text-purple-800',
                    'croner': 'bg-cyan-400/30 text-cyan-600',
                };
                return colors[especialidad.toLowerCase()] || 'bg-gray-500 text-white';
            }
        }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="mb-4 text-xl font-semibold leading-tight text-gray-800">
                    Draft
                </h3> 
                <div class="flex space-x-4">
                    <fieldset aria-label="Choose a filter option">
                        <div class="grid grid-cols-3 gap-3 mt-2 mb-1 sm:grid-cols-6">
                            @foreach($botones as $boton => $label)
                                <label :class="{
                                    'bg-indigo-600 text-white hover:bg-indigo-500 ring-0': selectedFilter === '{{ $boton }}',
                                    'ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50': selectedFilter !== '{{ $boton }}'
                                }" class="flex items-center justify-center px-3 py-3 text-sm font-semibold uppercase rounded-md cursor-pointer focus:outline-none sm:flex-1">
                                    <input type="radio" name="filter-option" value="{{ $boton }}" class="sr-only" @click="selectedFilter = '{{ $boton }}'">
                                    <span>{{ $label }}</span>
                                </label>
                            @endforeach
                            <label :class="{
                                'bg-indigo-600 text-white hover:bg-indigo-500 ring-0': selectedFilter === 'U24',
                                'ring-1 ring-gray-300 bg-white text-gray-900 hover:bg-gray-50': selectedFilter !== 'U24'
                            }" class="flex items-center justify-center px-3 py-3 text-sm font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer focus:outline-none sm:flex-1 ring-1 ring-gray-300 hover:bg-gray-50">
                                <input type="radio" name="filter-option" value="colores" class="sr-only" @click="selectedFilter = 'U24'">
                                <span>Colores</span>
                            </label>
                                <div>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'ard'" name="filter-option" class="sr-only" @click="selectedFilter = 'ard'">
                                            <span x-text="'ard'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'cro'" name="filter-option" class="sr-only" @click="selectedFilter = 'cro'">
                                            <span x-text="'cro'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'esc'" name="filter-option" class="sr-only" @click="selectedFilter = 'esc'">
                                            <span x-text="'esc'"></span>
                                        </label>
                                </div>
                                <div>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'spr'" name="filter-option" class="sr-only" @click="selectedFilter = 'spr'">
                                            <span x-text="'spr'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'com'" name="filter-option" class="sr-only" @click="selectedFilter = 'com'">
                                            <span x-text="'com'"></span>
                                        </label>
                                        <label :class="{
                                                'bg-pink-600 text-white hover:bg-pink-500 ring-0': selectedFilter === 'Option',
                                                'ring-1 ring-gray-300 bg-white text-xxs text-gray-900 hover:bg-gray-50': selectedFilter !== 'Option'
                                            }"
                                            class="flex items-center justify-center flex-1 w-1/2 px-1 py-0.5 text-xs font-semibold text-gray-900 uppercase bg-white rounded-md cursor-pointer h-1/3 focus:outline-none ring-1 ring-gray-300 hover:bg-gray-50">
                                            <input type="radio" :value="'fla'" name="filter-option" class="sr-only" @click="selectedFilter = 'fla'">
                                            <span x-text="'fla'"></span>
                                        </label>
                                </div>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead>
                        <tr>
                            @foreach($columns as $column => $label)
                                <th class="px-2 py-1.5 text-xxs leading-none uppercase">
                                    <div class="flex items-center space-x-2">
                                        <span @click="sort('{{ $column }}', order === 'asc' ? 'desc' : 'asc')" class="cursor-pointer">
                                            {{ $label }}
                                        </span>
                                        <div class="flex flex-col text-gray-400">
                                            <span @click="sort('{{ $column }}', 'desc')" class="leading-none cursor-pointer">˄</span>
                                            <span @click="sort('{{ $column }}', 'asc')" class="leading-none cursor-pointer">˅</span>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="ciclista in sortedCiclistas()" :key="ciclista.id">
                            <tr class="hover:bg-slate-100">
                                <template x-for="(label, field) in {{ json_encode($columns) }}" :key="field">
                                    <td x:class="{ 'bg-red-200': colorMode }" class="px-2 py-1.5 text-xs text-right">
                                        <template x-if="['lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com', 'ene', 'res', 'rec', 'media', 'total_puntos'].includes(field)">
                                            <span>
                                                <span x-text="formatNumber(ciclista[field]).integerPart" class="text-xs"></span><span x-text="'.' + formatNumber(ciclista[field]).decimalPart" class="inline-block text-gray-400 text-xxs"></span>
                                            </span>
                                        </template>
                                        <template x-if="['especialidad'].includes(field)">
                                                <span :class="getBadgeColor(ciclista.especialidad)" class="px-1 py-0.5 rounded text-xxs">
                                                    <span x-text="ciclista.especialidad.slice(0, 3).toUpperCase()"></span>
                                                </span>
                                            
                                        </template>
                                        <template x-if="!['especialidad', 'lla', 'mon', 'col', 'cri', 'pro', 'pav', 'spr', 'acc', 'des', 'com', 'ene', 'res', 'rec', 'media', 'total_puntos'].includes(field)">
                                            <span x-text="ciclista[field]"></span>
                                        </template>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
