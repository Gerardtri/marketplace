<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    if (Auth::Check()) {
        return redirect('/home');
    }
    return view('login');
});
Route::get('/login', function () {
    if (Auth::Check()) {
        return redirect('/home');
    }
    // Si el usuario ya está autenticado, redirigir a la página de inicio
    // Si no, mostrar la vista de inicio de sesión
    
    return view('login');
})-> name('login');



Route::get('/register', function () {
    return view('register');
});
Route::get('/terminos-condiciones', function () {
    return view('terminos');
});
Route::post('register', [LoginController::class, 'register']);
Route::post('check', [LoginController::class, 'check']);


Route::middleware('auth')->group(function () {
    
Route::get('/home', function () {
    return view('home');
})->middleware('auth');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('categorias', CategoriaController::class)->middleware('auth');
Route::resource('ciudades', CiudadController::class);
});

Route::resource('usuarios', UsuarioController::class);
Route::resource('productos', ProductoController::class);
Route::resource('comentarios', ComentarioController::class);
// route::resource('/categorias', [CategoriaController::class, 'index']);
// Route::resource('/ciudades', [CiudadController::class, 'index']);
// Route::resource('/usuarios',[UsuarioController::class,'index']); 
// Route::resource('/productos',[ProductoController::class,'index']);
// Route::resource('/comentarios',[ComentarioController::class,'index']);
