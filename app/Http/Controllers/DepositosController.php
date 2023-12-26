<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos lo modelos
use App\Models\Deposito;
//fechas
use Carbon\Carbon;
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

class DepositosController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-depositos|crear-depositos|editar-depositos|borrar-depositos', ['only' => ['index']]);

        $this->middleware('permission:crear-depositos', ['only' => ['create', 'store']]);
        //editar
        $this->middleware('permission:editar-depositos', ['only' => ['edit', 'update']]);
        //borrar
        $this->middleware('permission:borrar-depositos', ['only' => ['destroy']]);
        //ver eliminados
        $this->middleware('permission:ver-eliminados')->only('eliminadosCursos');
    }
    //controlador para ver los cursos eliminados
    public function eliminadosDeposito()
    {
        $registrosEliminados = Deposito::onlyTrashed()->get();
        return view('depositos.eliminado', compact('registrosEliminados'));
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
        $orden = $request->input('orden', 'desc');

        // Validación de fechas y consulta
        $query = Deposito::query();
        //filtramos las fechas en un rango donde se toma en cuenat el inicio y el fin 
        if ($fechaInicio !== null && $fechaFin !== null) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('created_at', '>=', $fechaInicio)
                    ->whereDate('created_at', '<=', $fechaFin);
            });
        }

        //suma de la tabla depositos
        $sumaDepositos = $query->sum('Monto');

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los cursos
        $depositos = $query->orderBy('created_at', $orden)->paginate(10);

        //pdf
        //fechas convertidas
        if (!$fechaInicio && !$fechaFin) {
            $fechaMinima = Deposito::min('created_at'); 
            $fechaMaxima = Deposito::max('created_at'); 

            $fechaFormateadaInicio = Carbon::parse($fechaMinima)->isoFormat('D [de] MMMM [del] YYYY');
            $fechaFormateadaFin = Carbon::parse($fechaMaxima)->isoFormat('D [de] MMMM [del] YYYY');
        } else {
            // Convertir fechas proporcionadas al formato unix
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
                'depositos' => $depositos,
                'sumaDepositos' => $sumaDepositos,
                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
                'fechaFormateadaInicio' => $fechaFormateadaInicio,
                'fechaFormateadaFin' => $fechaFormateadaFin,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('depositos.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Depositos.pdf');
        }

        return view('depositos.index', compact('depositos', 'sumaDepositos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* return view('depositos.crear'); */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Nro_de_transaccion' => 'required|integer',
            'Nombre' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Monto' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        Deposito::create($request->all());
        return redirect()->route('cursos.index');
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
    public function edit(Deposito $deposito)
    {
        return view('depositos.editar', compact('deposito'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deposito $deposito)
    {
        request()->validate([
            'Nro_de_transaccion' => 'required|integer',
            'Nombre' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Monto' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $deposito->update($request->all());
        return redirect()->route('depositos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deposito $deposito)
    {
        /* $deposito->delete();
        return redirect()->route('depositos.index'); */
    }
}
