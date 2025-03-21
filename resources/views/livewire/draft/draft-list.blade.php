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

        $this->ciclistas = Ciclista::with('equipo') // Carga la relación equipo
            ->where('temporada', 5)
            ->where('draft', 'u24')
            ->where('pos_draft', null)
            ->orderBy('media', 'desc')
            ->get();
    }

}; ?>

<div class="mt-6 bg-white rounded-lg shadow-sm"> 






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
<div x-data="{
    selectedCiclista: @entangle('selectedCiclista').defer,
    setCiclista(id) {
        this.selectedCiclista = id;
        $wire.setSelectedCiclista(id);
    }
}">
 
    <!-- Mostrar ciclista seleccionado -->
    <div x-show="selectedCiclista" class="p-4 mt-4 bg-gray-100 border border-gray-300 rounded-md">
        <p class="text-sm text-gray-700">
            Ciclista seleccionado: <strong x-text="selectedCiclista"></strong>
        </p>
    </div>
        
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
    x-data="{ selectable: {{ empty($ciclista->cod_equipo) ? 'true' : 'false' }} }"
    x-on:click="if (selectable) setCiclista({{ $ciclista->cod_ciclista }})"
    :class="{ 'hover:bg-blue-100': selectable, 'cursor-not-allowed bg-gray-100 text-gray-300': !selectable }"
    class="cursor-pointer">
                <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap"><x-team-badge :tipo="$ciclista->equipo?->siglas" /></td>
                <td class="relative px-7 sm:w-12 sm:px-6">
                    <!-- Solo mostrar radio si es seleccionable -->
<template x-if="selectable">
    <input type="radio" name="selected_ciclista"
        :checked="selectedCiclista == {{ $ciclista->cod_ciclista }}"
        x-on:click.stop="setCiclista({{ $ciclista->cod_ciclista }})"
        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
</template>
                </td>
                <td class="py-0.5 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $ciclista->nom_abrev }}</td>
                <td class="px-3 py-0 text-sm text-gray-500 whitespace-nowrap"><x-badge :tipo="$ciclista->especialidad" /></td>
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

</div>

</div>
