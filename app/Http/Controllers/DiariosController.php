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
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        //ordenamiento por desendente y acendenete
        $orden = $request->input('orden', 'asc');

        //Obtenemos la fecha de ayer 
        $fechaAyer = Carbon::now()->subDay()->toDateString();

        //vemos si el saldo de ayer del dia actual fue cero
        $registroAyer = Ingresoegreso::whereDate('fecha', $fechaAyer)->first();
        $saldoAyer = $registroAyer ? $registroAyer->Saldo : 0;

        //mostramos los datos de la tabla diarios solo los ultimos registros ingresados del dia actual
        $diarios = Diario::orderBy('created_at', 'desc')->take(1)->get();

        //filtrando por dia ingresado desde buscador
        $fechaIngresada = $request->input('fecha');
        $fechaActual = $fechaIngresada ? Carbon::parse($fechaIngresada)->toDateString() : Carbon::today()->toDateString();

        // Obtener los ingresos de cursos y alquileres del día actual(sumas)
        $sumaCursosActual = Curso::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaAlquileresActual = Alquilere::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaDepositosActual = Deposito::whereDate('created_at', $fechaActual)->sum('Monto');
        $sumaGastosActual = Gasto::whereDate('created_at', $fechaActual)->sum('Monto');

        //tabla de cortes de billetes y monedas de la tabla recorte 
        $ultimoRegistro = Diario::whereDate('created_at', $fechaActual)->latest()->first();
        $sumaRecorte = ($ultimoRegistro->monedas ?? 0) + ($ultimoRegistro->billetes ?? 0);

        // Obtener el valor de IngresosEgresos del día anterior
        //saldo inicial
        $saldoDiaAnterior = Ingresoegreso::whereDate('fecha', today()->subDay())->value('Saldo');

        // Si hay una fecha filtrada, obtener el registro del día anterior a esa fecha
        if ($fechaIngresada) {
            $saldoDiaAnterior = Ingresoegreso::whereDate('fecha', '<', $fechaIngresada)
                ->orderByDesc('fecha')
                ->first();
        } else {
            // Si no hay fecha filtrada, obtener el registro del día anterior al día actual
            $saldoDiaAnterior = Ingresoegreso::whereDate('fecha', today()->subDay())
                ->first();
        }
        // Obtener el valor del día anterior y si no existe asignarle un cero 
        $saldoDiaAnterior = $saldoDiaAnterior ? $saldoDiaAnterior->Saldo : 0;

        //suma total de la tala cursos y alquileres y ademas es
        //saldo final del dia
        $sumaCursosAlquileresAnteriorActual = $sumaCursosActual + $sumaAlquileresActual + $saldoDiaAnterior;

        //total de las tablas recorte depositos gastos
        $sumaDepGasRecActual = $sumaDepositosActual + $sumaGastosActual + $sumaRecorte;

        //para mostrar las tablas que se crearon en el dia 
        $alquileres = Alquilere::whereDate('created_at', $fechaActual)->orderBy('created_at', $orden)->get();
        $cursos = Curso::whereDate('created_at', $fechaActual)->orderBy('created_at', $orden)->get();
        $depositos = Deposito::whereDate('created_at', $fechaActual)->orderBy('created_at', $orden)->get();
        $gastos = Gasto::whereDate('created_at', $fechaActual)->orderBy('created_at', $orden)->get();

        //pdf
        //fecha convertida 
        $fechaActualFormateada = Carbon::parse($fechaActual)->isoFormat('D [de] MMMM [del] YYYY');

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
                'alquileres' => $alquileres,
                'cursos' => $cursos,
                'depositos' => $depositos,
                'gastos' => $gastos,
                'diarios' => $diarios,
                'saldoDiaAnterior' => $saldoDiaAnterior,
                'sumaCursosAlquileresAnteriorActual' => $sumaCursosAlquileresAnteriorActual,
                'fechaActual' => $fechaActual,
                'fechaAyer' => $fechaAyer,
                'sumaAlquileresActual' => $sumaAlquileresActual,
                'sumaCursosActual' => $sumaCursosActual,
                'sumaDepositosActual' => $sumaDepositosActual,
                'sumaGastosActual' => $sumaGastosActual,
                'sumaDepGasRecActual' => $sumaDepGasRecActual,
                'sumaRecorte' => $sumaRecorte,
                'saldoAyer' => $saldoAyer,
                'registroAyer' => $registroAyer,
                'fechaIngresada' => $fechaIngresada,
                'ultimoRegistro' => $ultimoRegistro,
                'fechaActualFormateada' => $fechaActualFormateada,

                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('diarios.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Reporte-Diario-de-caja.pdf');
        }

        return view('diarios.index', compact('diarios', 'saldoDiaAnterior', 'sumaCursosAlquileresAnteriorActual', 'fechaActual', 'fechaAyer', 'sumaAlquileresActual',  'sumaCursosActual', 'sumaDepositosActual', 'sumaGastosActual', 'sumaDepGasRecActual', 'sumaRecorte', 'saldoAyer', 'registroAyer', 'fechaIngresada'))->with([
            'ultimoRegistro' => $ultimoRegistro,
            //demas variables
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
            'monedas' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
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
        //modificar el saldo inicial del dia 

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
