<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos lo modelos
use App\Models\GastoExtraordinario;

class GastoExtraordinarioController extends Controller
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
    public function index()
    {
        $gastos = GastoExtraordinario::paginate(5);
        return view('frm_gastos.index', compact('gastos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frm_gastos.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Motivo_resumido_de_salida_de_dinero' => 'required',
            'Nombre_a_quien_se_entreg el_dinero' => 'required',
            'Quien_aprobo_la_ entrega_de_dinero' => 'required',
            'Nro_de_comprobante' => 'required|integer',
            'Monto' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        GastoExtraordinario::create($request->all());
        return redirect()->route('frm_gastos.index');
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
    public function edit(GastoExtraordinario $gasto)
    {
        return view('frm_gastos.editar', compact('gasto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GastoExtraordinario $gasto)
    {
        request()->validate([
            'Motivo_resumido_de_salida_de_dinero' => 'required',
            'Nombre_a_quien_se_entreg el_dinero' => 'required',
            'Quien_aprobo_la_ entrega_de_dinero' => 'required',
            'Nro_de_comprobante' => 'required|integer',
            'Monto' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $gasto->update($request->all());
        return redirect()->route('frm_gastos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GastoExtraordinario $gasto)
    {
        $gasto->delete();
        return redirect()->route('frm_gastos.index');
    }
}
