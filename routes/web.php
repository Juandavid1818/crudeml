<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

/**
 * Rutas relacionadas con la gestión de usuarios.
 */

// Ruta para mostrar la lista de usuarios activos
Route::get('/usuarios', [UsuarioController::class, 'index']);

// Ruta principal (redirige a la lista de usuarios activos)
Route::get('/', [UsuarioController::class, 'index'])->name('index');

// Ruta para desactivar un usuario por ID
Route::get('/usuarios/desactivar/{id}', [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');

// Ruta para activar un usuario por ID
Route::get('/usuarios/activar/{id}', [UsuarioController::class, 'activar'])->name('usuarios.activar');

// Ruta para obtener los datos de un usuario para su edición (API JSON)
Route::get('/usuarios/edit/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');

// Ruta para actualizar los datos de un usuario
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');

// Ruta para guardar un nuevo usuario
Route::post('/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');

// Ruta para obtener la vista de edición de un usuario por ID (HTML)
Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit']);

// Ruta para mostrar la lista de usuarios desactivados
Route::get('/usuarios-desactivados', [UsuarioController::class, 'usuario'])->name('usuarios.desactivados');
