<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//tablas a mostrar
use App\Models\Alquilere;
use App\Models\Constructora;
use App\Models\Curso;
use App\Models\Deposito;
use App\Models\Gasto;
use App\Models\Diario;
//reportes
use App\Models\Ingresoegreso;
//fechas
use Carbon\Carbon;

class DiariosController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:|editar-depositos', ['only' => ['index']]);
        $this->middleware('permission:editar-depositos', ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mostramos los datos de la tabla 
        $diarios = Diario::orderBy('created_at', 'desc')->take(1)->get();

        //sumas y restas de tablas
        $sumaCursos = Curso::sum('Ingresos');
        $sumaAlquileres = Alquilere::sum('Ingresos');
        $sumaDepositos = Deposito::sum('Monto');
        $sumaGastos = Gasto::sum('Monto');
        //saldo inicial del dia
        // Obtener el valor de IngresosEgresos del día anterior
        $saldoDiaAnterior = Ingresoegreso::whereDate('fecha', today()->subDay())->value('Ingreso');
        //saldo final del dia
        $sumaIngresos = $sumaCursos + $sumaAlquileres;

        //tablas sumadas solo del dia actual
        $fechaActual = Carbon::today();
        // Obtener los ingresos de cursos y alquileres del día actual
        $sumaCursosActual = Curso::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaAlquileresActual = Alquilere::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaDepositosActual = Deposito::whereDate('created_at', $fechaActual)->sum('Monto');
        $sumaGastosActual = Gasto::whereDate('created_at', $fechaActual)->sum('Monto');
        $ultimoRegistro = Diario::latest()->first();
        $sumaRecorte = ($ultimoRegistro->monedas ?? 0) + ($ultimoRegistro->billetes ?? 0);
        //sumando para la tablas actuales
        $sumaCursosAlquileresActual = $sumaCursosActual + $sumaAlquileresActual;
        $sumaDepGasRecActual = $sumaDepositosActual + $sumaGastosActual + $sumaRecorte;
        $saldoTotal = $sumaCursosAlquileresActual + $sumaDepGasRecActual;

        //para mostrar las tablas que se crearon en el dia 
        $fecha = date('Y-m-d');
        $alquileres = Alquilere::whereDate('created_at', $fecha)->get();
        $cursos = Curso::whereDate('created_at', $fecha)->get();
        $depositos = Deposito::whereDate('created_at', $fecha)->get();
        $gastos = Gasto::whereDate('created_at', $fecha)->get();

        return view('diarios.index', compact('diarios', 'sumaIngresos', 'saldoDiaAnterior',  'sumaCursosActual', 'sumaAlquileresActual', 'sumaDepositosActual', 'sumaGastosActual', 'sumaCursosAlquileresActual', 'sumaDepGasRecActual', 'sumaRecorte'))->with([
            'alquileres' => $alquileres,
            'cursos' => $cursos,
            'depositos' => $depositos,
            'gastos' => $gastos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'monedas' => 'numeric',
            'billetes' => 'numeric',
        ]);

        // Guardar los datos en la base de datos
        Diario::create([
            'monedas' => $request->monedas,
            'billetes' => $request->billetes,
        ]);
        return redirect()->route('diarios.index')->with('success', 'Creado con éxito c:');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
