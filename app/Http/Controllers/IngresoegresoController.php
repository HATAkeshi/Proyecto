<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//modelos
use App\Models\Curso;
use App\Models\Alquilere;
use App\Models\Diario;
use App\Models\Ingresoegreso;
use App\Models\Gasto;
//fechas
use Carbon\Carbon;
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

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

        //pdf
        //fechas convertidas
        if (!$fechaInicio && !$fechaFin) {
            $fechaMinima = Ingresoegreso::min('fecha');
            $fechaMaxima = Ingresoegreso::max('fecha');

            $fechaFormateadaInicio = Carbon::parse($fechaMinima)->isoFormat('D [de] MMMM [del] YYYY');
            $fechaFormateadaFin = Carbon::parse($fechaMaxima)->isoFormat('D [de] MMMM [del] YYYY');
        } else {
            // Convertir fechas proporcionadas al formato literal unix
            $fechaInicioFormato = $fechaInicio ? Carbon::parse($fechaInicio)->toDateString() : Carbon::today()->toDateString();
            $fechaFinFormato = $fechaFin ? Carbon::parse($fechaFin)->toDateString() : Carbon::today()->toDateString();

            $fechaFormateadaInicio = Carbon::parse($fechaInicioFormato)->isoFormat('D [de] MMMM [del] YYYY');
            $fechaFormateadaFin = Carbon::parse($fechaFinFormato)->isoFormat('D [de] MMMM [del] YYYY');
        }

        // Obtener la fecha actual
        $fecha_actual = Carbon::now()->toDateString(); // Formato 'año-mes-día'

        // Obtener la hora actual
        $hora_actual = Carbon::now()->toTimeString(); // Formato 'hora:minuto:segundo'

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();

        // Acceder al nombre y rol del usuario autenticado
        $nombreUsuario = $usuarioAutenticado->name;
        $rolUsuario = $usuarioAutenticado->roles->first()->name;

        // Si se solicita generar un PDF, entonces se generará y se enviará
        if ($request->has('generar_pdf')) {
            //pasamos datos
            $data = [
                'ingresoegresos' => $ingresoegresos,
                'sumaIngresos' => $sumaIngresos,
                'sumaEgresos' => $sumaEgresos,
                'sumaSaldo' => $sumaSaldo,
                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
                'fechaFormateadaInicio' => $fechaFormateadaInicio,
                'fechaFormateadaFin' => $fechaFormateadaFin,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('ingresoegresos.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Inresos-Egresos.pdf');
        }

        return view('ingresoegresos.index', compact('ingresoegresos', 'sumaIngresos', 'sumaEgresos', 'sumaSaldo'));
    }

    //metodo para hacer que si es cero el saldo inicial me deje añadir un saldo nuevo 
    public function agregarSaldoDiaAnterior(Request $request)
    {
        //request
        $request->validate([
            'saldo_manual' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();

        //Obtenemos la fecha de ayer 
        $fechaAyer = Carbon::now()->subDay()->toDateString();

        //verificar si hay un registro de ayer de la fecha actual 
        $registroAyer = Ingresoegreso::whereDate('fecha', $fechaAyer)->first();

        if ($registroAyer) {
            // Actualizar el registro existente
            $registroAyer->update([
                'Saldo' => $request->saldo_manual,
                'Detalle' => 'Domingo - Feriado - Etc',
                'Nombre' => $usuarioAutenticado->name
            ]);
        } else {
            // Crear un nuevo registro
            Ingresoegreso::create([
                'Saldo' => $request->saldo_manual,
                'fecha' => $fechaAyer,
                'Detalle' => 'Domingo - Feriado - Etc',
                'Nombre' => $usuarioAutenticado->name
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

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();

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
            $registroActual->Nombre = $usuarioAutenticado->name;
            $registroActual->Ingreso = $sumaCursosAlquileresAnteriorActual;
            $registroActual->Egreso = $sumaGastosActual;
            $registroActual->Saldo = $sumaCursosAlquileresAnteriorActual - $sumaGastosActual;
            $registroActual->save();
        } else {
            // Si no existe un registro para la fecha actual, crea uno nuevo
            $nuevoRegistro = new Ingresoegreso();
            $nuevoRegistro->Nombre = $usuarioAutenticado->name;
            $nuevoRegistro->fecha = $fechaActual;
            $nuevoRegistro->Ingreso = $sumaCursosAlquileresAnteriorActual;
            $nuevoRegistro->Egreso = $sumaGastosActual;
            $nuevoRegistro->Saldo = $sumaCursosAlquileresAnteriorActual - $sumaGastosActual;
            $nuevoRegistro->save();
        }
        return redirect()->route('diarios.index')->with('Guardado con exito');
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
