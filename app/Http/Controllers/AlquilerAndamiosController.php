<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos el modelo 
use App\Models\AlquilerAndamio;

class AlquilerAndamiosController extends Controller
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
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alquileres = AlquilerAndamio::paginate(5);
        return view('frm_alquiler.index', compact('alquileres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frm_alquiler.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Nombre_de_persona_o_empresa' => 'required',
            'Detalle' => 'required',
            'Modulos' => 'required',
            'Plataforma' => 'required',
            'Retraso_de_entrega' => 'required',
            'Numero_de_comprobante' => 'required|integer',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        AlquilerAndamio::create($request->all());
        return redirect()->route('frm_alquiler.index');
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
    public function edit(AlquilerAndamio $alquilerAndamio)
    {
        return view('frm_alquiler.editar', compact('alquilerAndamios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlquilerAndamio $alquilerAndamio)
    {
        request()->validate([
            'Nombre_de_persona_o_empresa' => 'required',
            'Detalle' => 'required',
            'Modulos' => 'required',
            'Plataforma' => 'required',
            'Retraso_de_entrega' => 'required',
            'Numero_de_comprobante' => 'required|integer',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $alquilerAndamio->update($request->all());
        return redirect()->route('frm_alquiler.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlquilerAndamio $alquilerAndamio)
    {
        $alquilerAndamio->delete();
        return redirect()->route('frm_alquiler.index');
    }
}
