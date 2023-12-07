<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos el modelo
use App\Models\Curso;

class CursosController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-cursos|crear-cursos|editar-cursos|borrar-cursos', ['only'=>['index']]);

        $this->middleware('permission:crear-cursos', ['only'=>['create','store']]);
        //editar
        $this->middleware('permission:editar-cursos', ['only'=>['edit','update']]);
        //borrar
        $this->middleware('permission:borrar-cursos', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::paginate(5);
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cursos.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Nombre_de_persona' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Porcentaje_de_anticipo' => 'required|numeric',
            'Nombre_de_persona_pago_total' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Detalle_de_curso' => 'required|in:Carpiteria en Aluminio,Scketch Up - V-Ray,Manejo de Redes',
            'Numero_de_comprobante' => 'required|integer',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        Curso::create($request->all());
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
    public function edit(Curso $curso)
    {
        return view('cursos.editar', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        request()->validate([
            'Nombre_de_persona' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Porcentaje_de_anticipo' => 'required|integer',
            'Nombre_de_persona_pago_total' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Detalle_de_curso' => 'required|in:Carpiteria en Aluminio,Scketch Up - V-Ray,Manejo de Redes',
            'Numero_de_comprobante' => 'required|integer',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);
        $curso->update($request->all());
        return redirect()->route('cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index');
    }
}
