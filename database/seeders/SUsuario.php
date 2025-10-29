<?php

namespace Database\Seeders;

use App\Models\Usuarios;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class SUsuario extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuarios::factory()->create([
            'usuarios' => 'Mauricio',
            'email' => 'mauso.mty@gmail.com',
            'passuser' => Hash::make('asdasd'),
            'nivel' => 'super',
        ]);
    }
}
