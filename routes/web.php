<?php

use Illuminate\Support\Facades\Route;
//agregamos los controladores 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
//forularios
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ConstructorasController;
use App\Http\Controllers\AlquilereController;
use App\Http\Controllers\DepositosController;
use App\Http\Controllers\GastosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


//new
Route::group(['middleware' => ['auth']], function(){
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    //comienza los formularios
    Route::resource('cursos', CursosController::class);
    Route::resource('constructoras', ConstructorasController::class);
    Route::resource('alquileres', AlquilereController::class);
    Route::resource('depositos', DepositosController::class);
    Route::resource('gastos', GastosController::class);
});