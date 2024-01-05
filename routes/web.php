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
//reportes
use App\Http\Controllers\DiariosController;
use App\Http\Controllers\IngresoegresoController;
//graficos
use App\Http\Controllers\GraficasController;

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
    Route::get('/dashboard', [GraficasController::class, 'graficasIngresosEgresos'])->name('dashboard');
});


//new
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    //comienza los formularios
    //Cursos
    Route::resource('cursos', CursosController::class);
    //eliminados de cursos y restaurado
    Route::get('/eliminados-cursos', [CursosController::class, 'eliminadosCursos'])->name('eliminados-cursos');
    Route::put('/cursos/{id}/restore', [CursosController::class, 'restore'])->name('cursos.restore');
    //pdf personalizado
    Route::get('/cursos/{id}/pdfPersonal', [CursosController::class, 'pdfPersonal'])->name('cursos.pdfPersonal');
    //Constuctora
    Route::resource('constructoras', ConstructorasController::class);
    //eliminados de Constructora y restaurado
    Route::get('/eliminados-constructora', [ConstructorasController::class, 'eliminadosConstructora'])->name('eliminados-constructora');
    Route::put('/constructoras/{id}/restore', [ConstructorasController::class, 'restore'])->name('constructoras.restore');
    //Alquileres
    Route::resource('alquileres', AlquilereController::class);
    //eliminados de Constructora y restaurado
    Route::get('/eliminados-alquilere', [AlquilereController::class, 'eliminadosAlquilere'])->name('eliminados-alquilere');
    Route::put('/alquileres/{id}/restore', [AlquilereController::class, 'restore'])->name('alquileres.restore');
    //Depositos
    Route::resource('depositos', DepositosController::class);
    //eliminados de Constructora y restaurado aun no
    Route::get('/eliminados-deposito', [DepositosController::class, 'eliminadosDeposito'])->name('eliminados-deposito');
    //Gastos
    Route::resource('gastos', GastosController::class);
    //eliminados de Constructora y restaurado
    Route::get('/eliminados-gasto', [GastosController::class, 'eliminadosGasto'])->name('eliminados-gasto');
    Route::put('/gastos/{id}/restore', [GastosController::class, 'restore'])->name('gastos.restore');
    //pdf personalizado
    Route::get('/gastos/{id}/pdfPersonal', [GastosController::class, 'pdfPersonal'])->name('gastos.pdfPersonal');
    //Reportes
    Route::resource('diarios', DiariosController::class);
    Route::resource('ingresoegresos', IngresoegresoController::class);
    //modificar el saldo del dia anterior si es cero o no hubo registros
    Route::get('agregar-saldo-inicial', [IngresoegresoController::class, 'agregarSaldoDiaAnterior'])->name('agregar-saldo-inicial');
});
