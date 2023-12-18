<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos el modelo
use App\Models\Curso;
use App\Models\Deposito;
use Illuminate\Support\Facades\Validator;
//fechas
use Carbon\Carbon;

class CursosController extends Controller
{
    //opciones de permisos 
    function __construct()
    {
        $this->middleware('permission:ver-cursos|crear-cursos|editar-cursos|borrar-cursos', ['only' => ['index']]);

        $this->middleware('permission:crear-cursos', ['only' => ['create', 'store']]);
        //editar
        $this->middleware('permission:editar-cursos', ['only' => ['edit', 'update']]);
        //borrar
        $this->middleware('permission:borrar-cursos', ['only' => ['destroy']]);
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
        $query = Curso::query();
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los cursos
        $cursos = $query->orderBy('created_at', 'desc')->paginate(5);

        // Suma de todos los ingresos de cursos
        $sumaCursos = $query->sum('Ingresos');

        return view('cursos.index', compact('cursos', 'sumaCursos'));
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
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            //para depositos 
            'Nro_de_transaccion' => $request->metodo_pago === 'deposito' ? 'required|integer' : '',
            'Monto' => $request->metodo_pago === 'deposito' ? 'required|regex:/^\d+(\.\d{1,2})?$/' : '',
        ]);

        if ($request->metodo_pago === 'deposito') {
            // Crear un nuevo depósito
            $deposito = new Deposito();
            $deposito->Nro_de_transaccion = $request->Nro_de_transaccion;

            // Obtener el nombre de la persona del curso
            $nombrePersonaCurso = $request->input('Nombre_de_persona_pago_total');
            $deposito->Nombre = $nombrePersonaCurso;

            $deposito->Monto = $request->Monto;

            // Guardar el depósito asociado al curso
            $curso = Curso::create($request->except(['Nro_de_transaccion', 'Nombre', 'Monto'])); // Crear el curso sin los datos del depósito

            $deposito->curso_id = $curso->id; // Asignar el curso_id al depósito
            $deposito->save();
        } else {
            // Si el método de pago no es depósito, solo guardar los datos del curso
            Curso::create($request->all());
        }

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
        $cursos = Curso::with('depositos')->get();
        return view('cursos.editar', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $validator = Validator::make($request->all(), [
            'Nombre_de_persona' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Porcentaje_de_anticipo' => 'required|integer',
            'Nombre_de_persona_pago_total' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'Detalle_de_curso' => 'required|in:Carpiteria en Aluminio,Scketch Up - V-Ray,Manejo de Redes',
            'Ingresos' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            //para depositos 
            'Nro_de_transaccion' => $request->metodo_pago === 'deposito' ? 'required|integer' : '',
            'Monto' => $request->metodo_pago === 'deposito' ? 'required|numeric|regex:/^\d+(\.\d{1,2})?$/' : '',
        ]);

        $validator->sometimes('Nro_de_transaccion', 'required', function ($input) {
            return $input->metodo_pago === 'deposito';
        });

        //eliminio la validacion para el campo nombre
        /* $validator->sometimes('Nombre', 'required', function ($input) {
            return $input->metodo_pago === 'deposito';
        }); */

        $validator->sometimes('Monto', 'required', function ($input) {
            return $input->metodo_pago === 'deposito';
        });

        // Verifica si hay errores de validación
        if ($validator->fails()) {
            // Manejar los errores de validación aquí, por ejemplo:
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $curso->update($request->all());

        $curso->update($request->except(['Nro_de_transaccion', 'Nombre', 'Monto']));

        if ($request->metodo_pago === 'deposito') {
            $deposito = $curso->depositos()->first();

            // Obtener el nombre del curso y asignarlo al campo 'Nombre' del depósito
            $nombreCurso= $curso->Nombre_de_persona_pago_total;

            // Verificar si se encontró un depósito y hay cambios en los datos de depósito
            if ($deposito && ($request->Nro_de_transaccion || /* $request->Nombre || */ $request->Monto)) {
                $deposito->update([
                    'Nro_de_transaccion' => $request->Nro_de_transaccion,
                    /* 'Nombre' => $request->Nombre, */  //se debe de cambiar
                    'Nombre' => $nombreCurso,
                    'Monto' => $request->Monto,
                ]);
            } elseif (!$deposito && ($request->Nro_de_transaccion || /* $request->Nombre || */ $request->Monto)) {
                // Si no se encontró un depósito y se proporcionan datos para crear uno nuevo
                $curso->depositos()->create([
                    'Nro_de_transaccion' => $request->Nro_de_transaccion,
                    /* 'Nombre' => $request->Nombre, */  //se debe de cambiar
                    'Nombre' => $nombreCurso,
                    'Monto' => $request->Monto,
                ]);
            }
        }

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
