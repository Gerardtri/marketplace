<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProductoController;


Route::get('/', function () {
    return view('layout');
});

Route::resource('categorias', CategoriaController::class);
Route::resource('ciudades', CiudadController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('productos', ProductoController::class);
Route::resource('comentarios', ComentarioController::class);
// route::resource('/categorias', [CategoriaController::class, 'index']);
// Route::resource('/ciudades', [CiudadController::class, 'index']);
// Route::resource('/usuarios',[UsuarioController::class,'index']); 
// Route::resource('/productos',[ProductoController::class,'index']);
// Route::resource('/comentarios',[ComentarioController::class,'index']);
