<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario_competiciones extends Model
{
    protected $table = 'calendario_competiciones';

    protected $fillable = ['calendario_id', 'competicion_id', 'temporada'];
}
