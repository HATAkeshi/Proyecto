<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos el modelo 
use App\Models\Alquilere;
//fechas
use Carbon\Carbon;
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

class AlquilereController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-alquiler|crear-alquiler|editar-alquiler|borrar-alquiler')->only('index');

        $this->middleware('permission:crear-alquiler', ['only' => ['create', 'store']]);
        //editar
        $this->middleware('permission:editar-alquiler', ['only' => ['edit', 'update']]);
        //borrar
        $this->middleware('permission:borrar-alquiler', ['only' => ['destroy']]);
        //ver eliminados
        $this->middleware('permission:ver-eliminados')->only('eliminadosAlquilere');
        //restaurar eliminados
        $this->middleware('permission:restaurar-eliminados', ['only' => ['restore']]);
    }
    //controlador para ver los cursos eliminados
    public function eliminadosAlquilere()
    {
        $registrosEliminados = Alquilere::onlyTrashed()->get();
        return view('alquileres.eliminado', compact('registrosEliminados'));
    }
    //metodo para restaurar los cursos eliminados
    public function restore($id)
    {
        // Encuentra el curso eliminado por su ID
        $alquilere = Alquilere::withTrashed()->findOrFail($id);

        // Restaura el curso
        $alquilere->restore();

        // Redirecciona a la vista de registros eliminados
        return redirect()->route('eliminados-alquilere')->with('success', 'Alquiler restaurado exitosamente.');
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
        $query = Alquilere::query();

        //filtramos las fechas en un rango donde se toma en cuenat el inicio y el fin 
        if ($fechaInicio !== null && $fechaFin !== null) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('created_at', '>=', $fechaInicio)
                    ->whereDate('created_at', '<=', $fechaFin);
            });
        }

        //suam de todas las tablas
        $sumaAlquileres = $query->sum('Ingresos');

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los cursos
        $alquileres = $query->orderBy('created_at', $orden)->paginate(10);

        //pdf
        //fechas convertidas
        if (!$fechaInicio && !$fechaFin) {
            $fechaMinima = Alquilere::min('created_at'); 
            $fechaMaxima = Alquilere::max('created_at'); 

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

        //usuario autenticado
        $usuarioAutenticado = Auth::user();

        if ($usuarioAutenticado) {
            // Acceder al nombre del usuario autenticado
            $nombreUsuario = $usuarioAutenticado->name;
        
            // Verificar si el usuario tiene roles asignados antes de acceder al primer rol
            if ($usuarioAutenticado->roles->isNotEmpty()) {
                $rolUsuario = $usuarioAutenticado->roles->first()->name;
            } else {
                $rolUsuario = 'Sin roles asignados';
            }
        } else {
            $nombreUsuario = '';
            $rolUsuario = '';
        }

        // Si se solicita generar un PDF, entonces se generará y se enviará
        if ($request->has('generar_pdf')) {
            //pasamos datos
            $data = [
                'alquileres' => $alquileres,
                'sumaAlquileres' => $sumaAlquileres ,
                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
                'fechaFormateadaInicio' => $fechaFormateadaInicio,
                'fechaFormateadaFin' => $fechaFormateadaFin,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('alquileres.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Alquileres.pdf');
        }

        return view('alquileres.index', compact('alquileres', 'sumaAlquileres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alquileres.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Nombre_de_persona_o_empresa' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Detalle' => 'nullable|regex:/^[a-zA-Z0-9\s,.()]+$/u',
            'Modulos' => 'required|integer',
            'Plataforma' => 'required|integer',
            'Retraso_de_entrega' => 'nullable|regex:/^[a-zA-Z0-9\s,.()]+$/u',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $input = $request->except(['_token']);

        Alquilere::create($input);

        return redirect()->route('alquileres.index')->with('Creado con exito c:');
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
    public function edit(Alquilere $alquilere)
    {
        return view('alquileres.editar', compact('alquilere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alquilere $alquilere)
    {
        request()->validate([
            'Nombre_de_persona_o_empresa' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Detalle' => 'required|regex:/^[a-zA-Z\s,.()]+$/u',
            'Modulos' => 'required|integer',
            'Plataforma' => 'required|integer',
            'Retraso_de_entrega' => 'required|regex:/^[a-zA-Z\s,.()]+$/u',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $alquilere->update($request->all());
        return redirect()->route('alquileres.index')->with('Actualizado con exito c:');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alquilere $alquilere)
    {
        $alquilere->delete();
        return redirect()->route('alquileres.index');
    }
}
