<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reglamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

<div x-data="{ 
        activeAccordion: '', 
        setActiveAccordion(id) { 
            this.activeAccordion = (this.activeAccordion == id) ? '' : id 
        } 
    }" class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md">
    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
        <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
            <span>Bases del juego</span>
            <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div x-show="activeAccordion==id" x-collapse x-cloak>
            <div class="p-4 pt-0 opacity-70">
                Pines is a UI library built for AlpineJS and TailwindCSS.
            </div>
        </div>
    </div>
    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
        <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
            <span>Reglas del juego</span>
            <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div x-show="activeAccordion==id" x-collapse x-cloak>
            <div class="p-4 pt-0 opacity-70">
                Add AlpineJS and TailwindCSS to your page and then copy and paste any of these elements into your project.
            </div>
        </div>
    </div>
    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
        <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
            <span>Objetivos</span>
            <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div x-show="activeAccordion==id" x-collapse x-cloak>
            <div class="p-4 pt-0 opacity-70">
                Absolutely! Pines works with any other library or framework. Pines works especially well with the TALL stack.
            </div>
        </div>
    </div>
    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
        <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
            <span>Mercado de fichajes</span>
            <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div x-show="activeAccordion==id" x-collapse x-cloak>
            <div class="p-4 pt-0 opacity-70">
                Absolutely! Pines works with any other library or framework. Pines works especially well with the TALL stack.
            </div>
        </div>
    </div>
    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
        <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
            <span>Drafts</span>
            <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div x-show="activeAccordion==id" x-collapse x-cloak>
            <div class="p-4 pt-0 opacity-70">
                Absolutely! Pines works with any other library or framework. Pines works especially well with the TALL stack.
            </div>
        </div>
    </div>
</div>                 
                    
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>