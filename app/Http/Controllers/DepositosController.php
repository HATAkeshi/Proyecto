<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos lo modelos
use App\Models\Deposito;

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
        $depositos = $query->orderBy('created_at', $orden)->paginate(5);

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
