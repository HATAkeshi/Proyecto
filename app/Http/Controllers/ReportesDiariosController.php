<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//tablas a mostrar
use App\Models\Alquilere;
use App\Models\Constructora;
use App\Models\Curso;
use App\Models\Deposito;
use App\Models\Gasto;
//fechas
use Carbon\Carbon;

class ReportesDiariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //sumas y restas de tablas
        $sumaCursos = Curso::sum('Ingresos');
        $sumaAlquileres = Alquilere::sum('Ingresos');
        $sumaDepositos = Deposito::sum('Monto');
        $sumaGastos = Gasto::sum('Monto');
        $sumaIngresos = $sumaCursos + $sumaAlquileres;
        $restandoEgresos = $sumaIngresos - $sumaGastos;
        
        //tablas sumadas solo del dia actual
        $fechaActual = Carbon::today();
        // Obtener los ingresos de cursos y alquileres del día actual
        $sumaCursosActual = Curso::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaAlquileresActual = Alquilere::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaDepositosActual = Deposito::whereDate('created_at', $fechaActual)->sum('Monto');
        $sumaGastosActual = Gasto::whereDate('created_at', $fechaActual)->sum('Monto');
        //sumando para la tablas actuales
        $sumaCursosAlquileresActual = $sumaCursosActual + $sumaAlquileresActual;
        $sumaDepositosGastosActual = $sumaDepositosActual + $sumaGastosActual;

        //para mostrar las tablas que se crearon en el dia 
        $fecha = date('Y-m-d');
        $alquileres = Alquilere::whereDate('created_at', $fecha)->get();
        $cursos = Curso::whereDate('created_at', $fecha)->get();
        $depositos = Deposito::whereDate('created_at', $fecha)->get();
        $gastos = Gasto::whereDate('created_at', $fecha)->get();

        return view('reportesdiarios.index', compact('restandoEgresos', 'sumaCursosActual', 'sumaAlquileresActual', 'sumaDepositosActual', 'sumaGastosActual', 'sumaCursosAlquileresActual', 'sumaDepositosGastosActual'))->with([
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
        //
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
