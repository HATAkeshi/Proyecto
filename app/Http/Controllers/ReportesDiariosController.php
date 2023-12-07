<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//tablas a mostrar
use App\Models\Alquilere;
use App\Models\Constructora;
use App\Models\Curso;
use App\Models\Deposito;
use App\Models\Gasto;

class ReportesDiariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      /*   //para filtrar por fecha 
        $fecha = $request->input('fecha');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta'); */

        //para mostrar las tablas que se crearon en el dia 
        $fecha = date('Y-m-d');
        $alquileres = Alquilere::whereDate('created_at', $fecha)->get();
        $cursos = Curso::whereDate('created_at', $fecha)->get();
        $depositos = Deposito::whereDate('created_at', $fecha)->get();
        $gastos = Gasto::whereDate('created_at', $fecha)->get();

        return view('reportesdiarios.index')->with([
            'alquileres' => $alquileres,
            'cursos' => $cursos,
            'depositos' => $depositos,
            'gastos' => $gastos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
