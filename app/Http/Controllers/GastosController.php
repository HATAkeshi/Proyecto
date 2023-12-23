<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos lo modelos
use App\Models\Gasto;

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
        $this->middleware('permission:ver-eliminados')->only('eliminadosCursos');
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

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los gastos
        $gastos = $query->orderBy('created_at', $orden)->paginate(5);

        //suma de todos los gastos
        $sumaGastos = $query->sum('Monto');

        return view('gastos.index', compact('gastos', 'sumaGastos'));
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
