<?php

use Illuminate\Foundation\Inspiring;
use App\Models\Inventario;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    $this->call('model:prune', [
        '--model' => [Inventario::class] 
    ]);

})->dailyAt('03:00')
  ->timezone('America/Mexico_City')
  ->name('inventario-pruning-task')
  ->withoutOverlapping();