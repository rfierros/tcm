<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    #[Validate('required|string|max:30')]
    public string $nombre = ''; 
 
    public function store(): void
    {
        $validated = $this->validate();
 
        auth()->user()->ciclistas()->create($validated);
 
        $this->nombre = '';
 
        $this->dispatch('ciclista-created');
    } 
}; ?>

<div>
    <form wire:submit="store"> 
        <textarea
            wire:model="nombre"
            placeholder="{{ __('Teclea el nombre del ciclista') }}"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>
 
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Grabar') }}</x-primary-button>
    </form> 
</div>
