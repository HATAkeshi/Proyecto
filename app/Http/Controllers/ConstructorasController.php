<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Constructora;
//fechas
use Carbon\Carbon;
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

class ConstructorasController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-constructora|crear-constructora|editar-constructora|borrar-constructora', ['only' => ['index']]);

        $this->middleware('permission:crear-constructora', ['only' => ['create', 'store']]);
        //editar
        $this->middleware('permission:editar-constructora', ['only' => ['edit', 'update']]);
        //borrar
        $this->middleware('permission:borrar-constructora', ['only' => ['destroy']]);
        //ver eliminados
        $this->middleware('permission:ver-eliminados')->only('eliminadosCursos');
        //restaurar eliminados
        $this->middleware('permission:restaurar-eliminados', ['only' => ['restore']]);
    }

    //controlador para ver los cursos eliminados
    public function eliminadosConstructora()
    {
        $registrosEliminados = Constructora::onlyTrashed()->get();
        return view('constructoras.eliminado', compact('registrosEliminados'));
    }
    //metodo para restaurar los cursos eliminados
    public function restore($id)
    {
        // Encuentra el curso eliminado por su ID
        $constructora = Constructora::withTrashed()->findOrFail($id);

        // Restaura el curso
        $constructora->restore();

        // Redirecciona a la vista de registros eliminados
        return redirect()->route('eliminados-constructora')->with('success', 'Constructora restaurado exitosamente.');
    }
    /**
     * Display a listing of the resource
     */
    public function index(Request $request)
    {
        //filtrador por fechas
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        //ordenamiento por desendente y acendenete
        $orden = $request->input('orden', 'desc');

        $query = Constructora::query();
        //filtramos las fechas en un rango donde se toma en cuenat el inicio y el fin 
        if ($fechaInicio !== null && $fechaFin !== null) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('created_at', '>=', $fechaInicio)
                    ->whereDate('created_at', '<=', $fechaFin);
            });
        }

        //suma de los registros de los costos
        $sumaConstructora = $query->sum('Costo');

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos las construcciones
        $constructoras = $query->orderBy('created_at', $orden)->paginate(10);

        //pdf
        //fechas convertidas
        if (!$fechaInicio && !$fechaFin) {
            $fechaMinima = Constructora::min('created_at'); 
            $fechaMaxima = Constructora::max('created_at'); 

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
                'constructoras' => $constructoras,
                'sumaConstructora' => $sumaConstructora,
                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
                'fechaFormateadaInicio' => $fechaFormateadaInicio,
                'fechaFormateadaFin' => $fechaFormateadaFin,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('constructoras.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Constructora.pdf');
        }

        return view('constructoras.index', compact('constructoras', 'sumaConstructora'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('constructoras.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Dueño_de_la_obra' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Direccion_de_la_obra' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Fecha_inicio_de_Obra' => 'required|date',
            'Fecha_fin_de_Obra' => 'required|date',
            'Costo' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        Constructora::create($request->all());
        return redirect()->route('constructoras.index');
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
    public function edit(Constructora $constructora)
    {
        return view('constructoras.editar', compact('constructora'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Constructora $constructora)
    {
        request()->validate([
            'Dueño_de_la_obra' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Direccion_de_la_obra' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Fecha_inicio_de_Obra' => 'required|date',
            'Fecha_fin_de_Obra' => 'required|date',
            'Costo' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $constructora->update($request->all());
        return redirect()->route('constructoras.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Constructora $constructora)
    {
        $constructora->delete();
        return redirect()->route('constructoras.index');
    }
}
