<?php

namespace App\Support;

class BadgeColor
{
    public static function get(?string $tipo): string
    {
        if (empty($tipo)) {
            return '';
        }

        $colores = [
            '15' => 'bg-pink-600/30 text-white',
            '33' => 'bg-yellow-700/30 text-orange-500',
            'sprinter' => 'bg-green-500/30 text-green-700',
            'escalador' => 'bg-yellow-800/30 text-yellow-900',
            'combativo' => 'bg-purple-800/30 text-purple-900',
            'croner' => 'bg-cyan-400/30 text-cyan-600',
        ];

        return $colores[strtolower($tipo)] ?? '';
    }
}
