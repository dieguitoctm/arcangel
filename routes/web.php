<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MenorController;
use App\Http\Controllers\AdminExportController; // <-- Importa el controlador de exportación

/*
|-------------------------------------------------------------------------- 
| Rutas públicas (Formulario y bienvenida) 
|-------------------------------------------------------------------------- 
*/

// Página de bienvenida
Route::get('/', [InscripcionController::class, 'bienvenida'])
    ->name('inscripcion.bienvenida');

// Formulario de inscripción de tutor (usuario + embarazo)
Route::get('/formulario', [InscripcionController::class, 'formulario'])
    ->name('inscripcion.formulario');

// Guardar tutor (usuario + embarazo)
Route::post('/formulario', [InscripcionController::class, 'guardar'])
    ->name('inscripcion.guardar');

// Formulario para agregar menor(es) ligado(s) a un tutor (usuario)
Route::get('/menor/{usuario}', [MenorController::class, 'formulario'])
    ->name('menor.formulario');

// Guardar menor ligado a tutor (usuario)
Route::post('/menor/{usuario}', [MenorController::class, 'guardar'])
    ->name('menor.guardar');

// Página de despedida, parámetro usuario opcional
Route::get('/despedida/{usuario?}', [InscripcionController::class, 'despedida'])
    ->name('inscripcion.despedida');

/*
|-------------------------------------------------------------------------- 
| Rutas de administración (CRUD) sin autenticación 
|-------------------------------------------------------------------------- 
*/

Route::prefix('admin')->group(function () {
    Route::get('/', [InscripcionController::class, 'index'])
        ->name('admin.index');

    Route::put('/{usuario}', [InscripcionController::class, 'update'])
        ->name('admin.update');

    Route::delete('/{usuario}', [InscripcionController::class, 'destroy'])
        ->name('admin.destroy');

    Route::put('/menores/{menor}', [MenorController::class, 'update'])
        ->name('menores.update');

    Route::delete('/menores/{menor}', [MenorController::class, 'destroy'])
        ->name('menores.destroy');

});
