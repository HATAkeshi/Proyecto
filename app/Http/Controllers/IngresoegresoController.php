<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//modelos
use App\Models\Curso;
use App\Models\Alquilere;
use App\Models\Ingresoegreso;
use App\Models\Gasto;
use Carbon\Carbon;

class IngresoegresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //filtrador por fechas
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Validación de fechas y consulta
        $query = Ingresoegreso::query();
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los cursos
       $ingresoegresos = $query->paginate(5);

        //suma del campo ingreso
        $sumaIngresos = $query->sum('Ingreso');
        //suma del campo de egresos
        $sumaEgresos = $query->sum('Egreso');
        //suma del campo saldo
        $sumaSaldo = $query->sum('Saldo');

        return view('ingresoegresos.index', compact('ingresoegresos', 'sumaIngresos', 'sumaEgresos', 'sumaSaldo'));
    }

    //creamos una funcion que guarda lo reportes
    public function guardarReportes()
    {
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
        $fechaActual = now();

        // Calcula la suma de Cursos y Alquileres
        $sumaCursosActual = Curso::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaAlquileresActual = Alquilere::whereDate('created_at', $fechaActual)->sum('Ingresos');

        //egreso
        $sumaGastosActual = Gasto::whereDate('created_at', $fechaActual)->sum('Monto');

        //saldo del dia anterior 
        $saldoDiaAnterior = Ingresoegreso::whereDate('fecha', today()->subDay())->value('Saldo');

        //ingresos
        //suma total de la tabla cursos, alquileres y el saldo anterior
        $sumaCursosAlquileresAnteriorActual = 
        $saldoDiaAnterior +  //saldo anterior
        $sumaCursosActual + //suma de los ingresos de cursos dela dia actual
        $sumaAlquileresActual; //suma de los ingresos de alquileres del dia actual

        //vemos si ya existe el registro y si es haci lo actualizamos en ves de crear uno nuevo 
        $registroActual = Ingresoegreso::whereDate('fecha', $fechaActual)->first();

        if ($registroActual) {
            // Si el registro existe para la fecha actual, actualiza los valores
            $registroActual->Ingreso = $sumaCursosAlquileresAnteriorActual;
            $registroActual->Egreso = $sumaGastosActual;
            $registroActual->Saldo = $sumaCursosAlquileresAnteriorActual - $sumaGastosActual;
            $registroActual->save();
        } else {
            // Si no existe un registro para la fecha actual, crea uno nuevo
            $nuevoRegistro = new Ingresoegreso();
            $nuevoRegistro->fecha = $fechaActual;
            $nuevoRegistro->Ingreso = $sumaCursosAlquileresAnteriorActual;
            $nuevoRegistro->Egreso = $sumaGastosActual;
            $nuevoRegistro->Saldo = $sumaCursosAlquileresAnteriorActual - $sumaGastosActual;
            $nuevoRegistro->save();
        }
        return redirect()->route('diarios.index')->with('Guardado con existo');
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
