<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modtrabajos extends Model
{
    protected $table = 'Trabajos';
    protected $fillable = [
        'Fila',
        'Numero',
        'SiNo',
    ];
}