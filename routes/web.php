<?php

use Illuminate\Support\Facades\Route;
//agregamos los controladores 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
//forularios
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ConstructoraController;
use App\Http\Controllers\AlquilerAndamiosController;
use App\Http\Controllers\DepositosController;
use App\Http\Controllers\GastoExtraordinarioController;

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
    Route::resource('frm_cursos', CursosController::class);
    Route::resource('frm_constructora', ConstructoraController::class);
    Route::resource('frm_alquiler', AlquilerAndamiosController::class);
    Route::resource('frm_depositos', DepositosController::class);
    Route::resource('frm_gastos', GastoExtraordinarioController::class);
});