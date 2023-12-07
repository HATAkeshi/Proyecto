<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Constructora;

class ConstructorasController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-constructora|crear-constructora|editar-constructora|borrar-constructora', ['only'=>['index']]);

        $this->middleware('permission:crear-constructora', ['only'=>['create','store']]);
        //editar
        $this->middleware('permission:editar-constructora', ['only'=>['edit','update']]);
        //borrar
        $this->middleware('permission:borrar-constructora', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $constructoras = Constructora::paginate(5);
        return view('constructoras.index', compact('constructoras'));
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
