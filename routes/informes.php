<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\inicio_sesion\LoginController;

// Route::middleware(['web'])->group(function () {
Route::middleware(['web', 'prevent-back-history'])->group(function () {
    Route::get('/', function () {
        // return view('inicio_sesion.login');
        return redirect()->route('login');
    })->name('login');

       // Rutas públicas
    Route::redirect('/', '/login');
    Route::get('/login', [LoginController::class, 'index'])->name('login');

    Route::group(['namespace' => 'App\Http\Controllers\informe'], function ()
    {
        Route::get('informe_usuarios', 'InformeController@informeGerencialUsuarios')->name('informe_usuarios');
        
        Route::post('respuesta', 'InformeController@respuesta')->name('respuesta');
    });

}); // FIN Route::middleware(['web'])

