<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Control;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Objetos;
use App\Http\Controllers\Sesion;

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

//Caso base
Route::get('login', [Sesion::class, 'RInicio']);

//Inicio
Route::get('/', [Sesion::class, 'Inicio'])->name('Login');

//Formulario del registro
Route::get('/crear', [Sesion::class, 'DarAlta'])->name('SignUp');

//Se crea el usuario
Route::post('/creado', [Sesion::class, 'SignUp'])->name('Registro');

//Valida los datos del login
Route::get('/validar', [Sesion::class, 'LogIn'])->name('Validacion');

//Cierra la sesion
Route::get('/logout',[Sesion::class, 'LogOut'])->name('Cierre');

//Route::middleware('auth')->group(function () {

    //Despliegue llena y espera confirmar
    Route::get('/modificar/{id}/{iduser}', [Admin::class, 'Modif'])->name('Modif');

    //Modifica los datos del usuario
    Route::post('/moddata/{id}/{iduser}', [Admin::class, 'Moddata'])->name('Moddata');

    //Despliegue llena y espera confirmar
    Route::get('/selfmodificar/{id}', [Control::class, 'Selfmodif'])->name('Selfmodif');

    //Modifica los datos del usuario
    Route::post('/selfmoddata/{id}', [Control::class, 'Selfmoddata'])->name('Selfmoddata');

    //Muestra usuarios
    Route::get('/consulta/{id}', [Admin::class, 'Consultas'])->name('Consultas');

    //Despliegue y expera confirma
    Route::get('/elim/{id}/{iduser}', [Admin::class, 'Quitar'])->name('Elimina');

    //Elimina al usuario
    Route::get('/exh{id}/{iduser}', [Admin::class, 'Exh'])->name('Exh');

    //Inicio despues de iniciar sesion
    Route::get('/inicio/{id}', [Control::class, 'Bienvenida'])->name('Inicio');

    //FOrmulario de objetos
    Route::get('/add/{id}', [Objetos::class, 'Agregar'])->name('Agregar');

    //Agregar objeto al usuario
    Route::post('/added/{id}', [Objetos::class, 'Add'])->name('Add');

    //Despliegue llena y espera confirmar
    Route::get('/modificarobj/{id}/{idobj}/{Tipo}', [Objetos::class, 'ModifObj'])->name('ModifObj');

    //Modifica los datos del objeto
    Route::post('/moddataobj/{id}/{idobj}', [Objetos::class, 'ModdataObj'])->name('ModdataObj');

    //Elimina al objeto, desactiva
    Route::get('/elimobj/{id}/{idobj}', [Objetos::class, 'QuitarObj'])->name('ElimObj');

    //Recuperar el objeto
    Route::get('/recover/{id}/{idobj}',[Objetos::class, 'Recuperar'])->name('Recuperar');

    //Registro de usuario por superusuario
    Route::get('/registro/{id}',[Admin::class, 'RegistroVista'])->name('RegistroVista');

    Route::post('/register/{id}',[Admin::class, 'Registro'])->name('RegistroUsuario');

    //Ver imagenes de usuario por superusuario
    Route::get('/objusuario/{id}/{iduser}', [Admin::class, 'ObjUsuario'])->name('ObjUsuario');

    //Agregar objeto al usuario por superusuario
    Route::post('/added/{id}/{iduser}', [Admin::class, 'Add'])->name('AddSU');

    //Despliegue llena y espera confirmar
    Route::get('/modificarobjSU/{id}/{iduser}/{idobj}/{Tipo}', [Admin::class, 'ModifObj'])->name('ModifObjSU');

    //Modifica los datos del objeto del usuario
    Route::post('/moddataobjSU/{id}/{iduser}/{idobj}', [Admin::class, 'ModdataObj'])->name('ModdataObjSU');

    //Elimina al objeto, desactiva
    Route::get('/elimobj/{id}/{iduser}/{idobj}', [Admin::class, 'QuitarObj'])->name('ElimObjSU');

    //Recuperar el objeto
    Route::get('/recoverSU/{id}/{iduser}/{idobj}',[Admin::class, 'Recuperar'])->name('RecuperarSU');

    //Elimina al objeto, desactiva
    Route::get('/encuestas/{id}', [Admin::class, 'Encuestas'])->name('Encuestas');

//});





