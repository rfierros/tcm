@props(['tipo'])

@php
    $colores = [
        'ardenas' => 'bg-pink-600/30 text-pink-700',
        'flandes' => 'bg-yellow-400/30 text-yellow-600',
        'sprinter' => 'bg-green-500/30 text-green-700',
        'escalador' => 'bg-yellow-800/30 text-yellow-900',
        'combatividad' => 'bg-purple-800/30 text-purple-900',
        'croner' => 'bg-cyan-400/30 text-cyan-600',
    ];

    $color = $colores[strtolower($tipo)] ?? 'bg-gray-500 text-white';
@endphp

<span class="px-1 py-0.5 rounded text-xxs uppercase w-7 inline-flex items-center justify-center {{ $color }}">
    {{ substr($tipo, 0, 3) }}
</span>
