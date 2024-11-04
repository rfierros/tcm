<?php


use Livewire\Volt\Component;
use App\Models\Carrera;

class EtapasList extends Component
{
    public Carrera $carrera;
    
    public function mount($carreraId)
    {
        $this->carrera = Carrera::with('etapas')->findOrFail($carreraId);
    }

    // El método render en Volt solo necesita devolver la vista y debe indicar `mixed` como tipo de retorno
    public function render(): mixed
    {
        return view('livewire.etapas-list');
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

