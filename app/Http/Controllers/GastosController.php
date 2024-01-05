<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos lo modelos
use App\Models\Gasto;
//fechas
use Carbon\Carbon;
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

class GastosController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-gastos|crear-gastos|editar-gastos|borrar-gastos', ['only' => ['index']]);

        $this->middleware('permission:crear-gastos', ['only' => ['create', 'store']]);
        //editar
        $this->middleware('permission:editar-gastos', ['only' => ['edit', 'update']]);
        //borrar
        $this->middleware('permission:borrar-gastos', ['only' => ['destroy']]);
        //ver eliminados
        $this->middleware('permission:ver-eliminados')->only('eliminadosGasto');
        //restaurar eliminados
        $this->middleware('permission:restaurar-eliminados', ['only' => ['restore']]);
    }
    //controlador para ver los cursos eliminados
    public function eliminadosGasto()
    {
        $registrosEliminados = Gasto::onlyTrashed()->get();
        return view('gastos.eliminados', compact('registrosEliminados'));
    }
    //metodo para restaurar los cursos eliminados
    public function restore($id)
    {
        // Encuentra el curso eliminado por su ID
        $gasto = Gasto::withTrashed()->findOrFail($id);

        // Restaura el curso
        $gasto->restore();

        // Redirecciona a la vista de registros eliminados
        return redirect()->route('eliminados-gasto')->with('success', 'Gasto restaurado exitosamente.');
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
        $query = Gasto::query();
        //filtramos las fechas en un rango donde se toma en cuenat el inicio y el fin 
        if ($fechaInicio !== null && $fechaFin !== null) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('created_at', '>=', $fechaInicio)
                    ->whereDate('created_at', '<=', $fechaFin);
            });
        }

        //suma de todos los gastos
        $sumaGastos = $query->sum('Monto');

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los gastos
        $gastos = $query->orderBy('created_at', $orden)->paginate(10);

        //pdf
        //fechas convertidas
        if (!$fechaInicio && !$fechaFin) {
            $fechaMinima = Gasto::min('created_at');
            $fechaMaxima = Gasto::max('created_at');

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
                'gastos' => $gastos,
                'sumaGastos' => $sumaGastos,
                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
                'fechaFormateadaInicio' => $fechaFormateadaInicio,
                'fechaFormateadaFin' => $fechaFormateadaFin,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('gastos.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Gastos.pdf');
        }

        return view('gastos.index', compact('gastos', 'sumaGastos'));
    }

    //pdf personalizado
    public function pdfPersonal($id)
    {
        $gasto = Gasto::findOrFail($id);

        $path_to_image = 'imagenesApoyo/logo-ludeno.svg';
        $type = pathinfo($path_to_image, PATHINFO_EXTENSION);
        $data = file_get_contents($path_to_image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $data = [
            'gasto' => $gasto,
            'base64Image' => $base64,
        ];

        $pdf = PDF::loadView('gastos.pdfPersonal', $data);

        return $pdf->stream('Recibo-gastos' . $id . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gastos.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Motivo_resumido_de_salida_de_dinero' => 'required|regex:/^[a-zA-Z0-9\s,.()]+$/u',
            'Nombre_a_quien_se_entrego_el_dinero' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Quien_aprobo_la_entrega_de_dinero' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Monto' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        Gasto::create($request->all());
        return redirect()->route('gastos.index');
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
    public function edit(Gasto $gasto)
    {
        return view('gastos.editar', compact('gasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gasto $gasto)
    {
        request()->validate([
            'Motivo_resumido_de_salida_de_dinero' => 'required|regex:/^[a-zA-Z0-9\s,.()]+$/u',
            'Nombre_a_quien_se_entrego_el_dinero' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Quien_aprobo_la_entrega_de_dinero' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Monto' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $gasto->update($request->all());
        return redirect()->route('gastos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gasto $gasto)
    {
        $gasto->delete();
        return redirect()->route('gastos.index');
    }
}
