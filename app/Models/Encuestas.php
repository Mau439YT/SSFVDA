<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuestas extends Model
{
    protected $table = 'Encuestas';

    protected $fillable = [

        'Contenido',

    ];
    protected $casts = [
        'Contenido' => 'array',
    ];
}
