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
        $this->middleware('permission:ver-gastos|crear-gastos|editar-gastos|borrar-gastos', ['only'=>['index']]);

        $this->middleware('permission:crear-gastos', ['only'=>['create','store']]);
        //editar
        $this->middleware('permission:editar-gastos', ['only'=>['edit','update']]);
        //borrar
        $this->middleware('permission:borrar-gastos', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //filtrador por fechas
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Validación de fechas y consulta
        $query = Gasto::query();
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los gastos
        $gastos = $query->orderBy('created_at', 'desc')->paginate(5);
        
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
            'Motivo_resumido_de_salida_de_dinero' => 'required|regex:/^[a-zA-Z\s,.()]+$/u',
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
            'Motivo_resumido_de_salida_de_dinero' => 'required|regex:/^[a-zA-Z\s,.()]+$/u',
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
