<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos el modelo 
use App\Models\Alquilere;

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
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alquileres = Alquilere::paginate(5);
        return view('alquileres.index', compact('alquileres'));
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
            'Nombre_de_persona_o_empresa' => 'required',
            'Detalle' => 'required',
            'Modulos' => 'required',
            'Plataforma' => 'required',
            'Retraso_de_entrega' => 'required',
            'Nro_de_comprobante' => 'required|integer',
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
            'Nombre_de_persona_o_empresa' => 'required',
            'Detalle' => 'required',
            'Modulos' => 'required',
            'Plataforma' => 'required',
            'Retraso_de_entrega' => 'required',
            'Numero_de_comprobante' => 'required|integer',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $alquilere->update($request->all());
        return redirect()->route('alquileres.index')->with('Actualizado con exito c:');;
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
