<?php

use Livewire\Volt\Component;
use App\Models\Carrera;
use App\Models\Etapa;
use Illuminate\Database\Eloquent\Collection;

class EtapasList extends Component
{
    public Carrera $carrera;
    public Collection $etapas;

    // Cambiamos el parámetro a $slug
    public function mount(string $slug): void
    {
        // Buscar la carrera por el slug
        $this->carrera = Carrera::where('slug', $slug)->firstOrFail();
        dd($slug);
        dd($this->carrera);
        $this->getEtapas();
    }

    public function getEtapas(): void
    {
                dd($slug);
        // Ahora obtenemos las etapas usando el id de la carrera encontrada
        $this->etapas = Etapa::where('carrera_id', $this->carrera->id)
            ->orderBy('num_etapa')
            ->get();
    }
}

?>

<div class="mt-6 bg-white divide-y rounded-lg shadow-sm"> 
    <div class="p-10">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden border rounded-lg">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead class="bg-neutral-50">
                                <tr class="text-neutral-500">
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase bg-green-200">Carrera</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Etapa</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Tipo</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Perfil</th>
                                    <th class="px-2 py-1.5 text-xs font-medium text-left uppercase">Día de Inicio</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @foreach ($carrera->etapas as $etapa)
                                <tr class="text-neutral-800">
                                         
                                    <td class="px-2 py-1.5 text-sm font-medium whitespace-nowrap">{{ $carrera->nombre }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap"><a href="{{ route('etapas.show', [$carrera->slug, $etapa->id]) }}" class="text-blue-500 hover:underline">Etapa {{ $carrera->num_etapa }}</a></td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $etapa->dia }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $etapa->perfil }}</td>
                                    <td class="px-2 py-1.5 text-sm whitespace-nowrap">{{ $etapa->dia_inicio }}</td>
                                </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

