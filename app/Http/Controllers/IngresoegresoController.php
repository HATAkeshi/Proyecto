<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//modelos
use App\Models\Curso;
use App\Models\Alquilere;
use App\Models\Diario;
use App\Models\Ingresoegreso;
use App\Models\Gasto;
use Carbon\Carbon;

class IngresoegresoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-Ingresos-Egresos')->only('index');
        //añadir saldo inicial permiso
        $this->middleware('permission:editar-saldo-inicial', ['only' => ['agregarSaldoDiaAnterior']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //filtrador por fechas
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        //ordenamiento por desendente y acendenete
        $orden = $request->input('orden', 'asc');

        // Validación de fechas y consulta
        $query = Ingresoegreso::query();

        //filtramos las fechas en un rango donde se toma en cuenat el inicio y el fin 
        if ($fechaInicio && $fechaFin) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('fecha', '>=', $fechaInicio)
                    ->whereDate('fecha', '<=', $fechaFin);
            });
        }

        //suma del campo ingreso
        $sumaIngresos = ($fechaInicio && $fechaFin) ? $query->sum('Ingreso') : Ingresoegreso::sum('Ingreso');
        //suma del campo de egresos
        $sumaEgresos = ($fechaInicio && $fechaFin) ? $query->sum('Egreso') : Ingresoegreso::sum('Egreso');
        //suma del campo saldo
        $sumaSaldo = ($fechaInicio && $fechaFin) ? $query->sum('Saldo') : Ingresoegreso::sum('Saldo');

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los Ingresos egresos
        $ingresoegresos = $query->orderBy('fecha', $orden)->paginate(10);

        return view('ingresoegresos.index', compact('ingresoegresos', 'sumaIngresos', 'sumaEgresos', 'sumaSaldo'));
    }

    //metodo para hacer que si es cero el saldo inicial me deje añadir un saldo nuevo 
    public function agregarSaldoDiaAnterior(Request $request)
    {
        //request
        $request->validate([
            'saldo_manual' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        //Obtenemos la fecha de ayer 
        $fechaAyer = Carbon::now()->subDay()->toDateString();

        //verificar si hay un registro de ayer de la fecha actual 
        $registroAyer = Ingresoegreso::whereDate('fecha', $fechaAyer)->first();

        if ($registroAyer) {
            // Actualizar el registro existente
            $registroAyer->update([
                'Saldo' => $request->saldo_manual,
                'Detalle' => 'Domingo - Feriado - Etc'
            ]);
        } else {
            // Crear un nuevo registro
            Ingresoegreso::create([
                'Saldo' => $request->saldo_manual,
                'fecha' => $fechaAyer,
                'Detalle' => 'Domingo - Feriado - Etc'
            ]);
        }
        return redirect()->route('diarios.index')->with('mensaje', 'Guardado con existo');
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
