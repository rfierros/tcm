@props(['tipo'])

@php
    $colores = [
        '1' => 'bg-white-500/30 text-black',
        '2' => 'bg-white-500/30 text-black',
        '3' => 'bg-white-500/30 text-black',
        '5' => 'bg-yellow-400/30 text-blue-500',
        '6' => 'bg-white-500/30 text-black',
        '8' => 'bg-yellow-300/30 text-lime-500',
        'ldl' => 'bg-blue-700/80 text-yellow-400',
        '10' => 'bg-orange-500/30 text-black',
        '11' => 'bg-red-500/30 text-white',
        '12' => 'bg-white-500/30 text-black',
        '13' => 'bg-white-500/30 text-black',
        '14' => 'bg-white-500/30 text-black',
        'kai' => 'bg-pink-600/30 text-white',
        '16' => 'bg-white-500/30 text-black',
        '20' => 'bg-white-500/30 text-black',
        '24' => 'bg-white-500/30 text-black',
        'fpk' => 'bg-yellow-600/30 text-orange-600',
        '34' => 'bg-white-500/30 text-black',
        '35' => 'bg-white-500/30 text-black',
        '42' => 'bg-white-500/30 text-black',
        '92' => 'bg-violet-500/30 text-white',
        '100' => 'bg-white-500/30 text-black',
        'dsm' => 'bg-cyan-500/30 text-black',
        '229' => 'bg-white-500/30 text-black',
    ];

    $color = $colores[strtolower($tipo)] ?? '';
@endphp
{{-- @php
    use App\Support\BadgeColor;

    $color = BadgeColor::get($tipo);
@endphp --}}

<span class="px-1 py-0.5 rounded text-xxs font-bold uppercase w-7 inline-flex items-center justify-center {{ $color }}">
    {{ substr($tipo, 0, 3) }}
</span>
