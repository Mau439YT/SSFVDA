<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable
{
     use HasFactory, Notifiable;

    protected $table = 'Usuarios';
    protected $fillable = [
        'usuarios',
        'email',
        'passuser',
        'Edad',
        'Sexo',
        'id_estado',
        'nivel',
    ];

    protected $hidden = [
        'passuser',
        'remember_token',
        'nivel',
    ];

    protected $casts = [
        'passuser' => 'hashed', 
    ];
}
