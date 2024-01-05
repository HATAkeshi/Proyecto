<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//referenciamos el modelo
use App\Models\Curso;
use App\Models\Deposito;
use Illuminate\Support\Facades\Validator;
//fechas
use Carbon\Carbon;
//pdf
use Barryvdh\DomPDF\Facade\Pdf;
//user
use Illuminate\Support\Facades\Auth;

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
        //ver eliminados
        $this->middleware('permission:ver-eliminados')->only('eliminadosCursos');
        //restaurar eliminados
        $this->middleware('permission:restaurar-eliminados', ['only' => ['restore']]);
    }
    //controlador para ver los cursos eliminados
    public function eliminadosCursos()
    {
        $registrosEliminados = Curso::onlyTrashed()->get();
        return view('cursos.eliminado', compact('registrosEliminados'));
    }
    //metodo para restaurar los cursos eliminados
    public function restore($id)
    {
        // Encuentra el curso eliminado por su ID
        $curso = Curso::withTrashed()->findOrFail($id);

        if ($curso) {
            // Verificar si el curso tiene un depósito eliminado
            $deposito = Deposito::onlyTrashed()->where('curso_id', $curso->id)->first();

            // Restaurar el depósito asociado, si existe
            if ($deposito) {
                $deposito->restore();
            }

            // Restaurar el curso
            $curso->restore();

            return redirect()->back()->with('success', 'Curso restaurado exitosamente.');
        }

        // Restaura el curso
        $curso->restore();

        // Redirecciona a la vista de registros eliminados
        return redirect()->route('eliminados-cursos')->with('success', 'Curso restaurado exitosamente.');
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
        $query = Curso::query();
        //filtramos las fechas en un rango donde se toma en cuenat el inicio y el fin 
        if ($fechaInicio !== null && $fechaFin !== null) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('created_at', '>=', $fechaInicio)
                    ->whereDate('created_at', '<=', $fechaFin);
            });
        }

        // Suma de todos los ingresos de cursos
        $sumaCursos = $query->sum('Ingresos');

        // Obtener los resultados filtrados por fecha y si no hay nada mostrar todos los cursos
        $cursos = $query->orderBy('created_at', $orden)->paginate(10);

        //pdf
        //fechas convertidas
        if (!$fechaInicio && !$fechaFin) {
            $fechaMinima = Curso::min('created_at'); 
            $fechaMaxima = Curso::max('created_at'); 

            $fechaFormateadaInicio = Carbon::parse($fechaMinima)->isoFormat('D [de] MMMM [del] YYYY');
            $fechaFormateadaFin = Carbon::parse($fechaMaxima)->isoFormat('D [de] MMMM [del] YYYY');
        } else {
            // Convertir fechas proporcionadas al formato unix
            $fechaInicioFormato = $fechaInicio ? Carbon::parse($fechaInicio)->toDateString() : Carbon::today()->toDateString();
            $fechaFinFormato = $fechaFin ? Carbon::parse($fechaFin)->toDateString() : Carbon::today()->toDateString();

            $fechaFormateadaInicio = Carbon::parse($fechaInicioFormato)->isoFormat('D [de] MMMM [del] YYYY');
            $fechaFormateadaFin = Carbon::parse($fechaFinFormato)->isoFormat('D [de] MMMM [del] YYYY');
        }

        // Obtener la fecha actual
        $fecha_actual = Carbon::now()->toDateString(); // Formato 'año-mes-día'

        // Obtener la hora actual
        $hora_actual = Carbon::now()->toTimeString(); // Formato 'hora:minuto:segundo'

        // Obtener el usuario autenticado
        $usuarioAutenticado = Auth::user();

        if ($usuarioAutenticado) {
            // Acceder al nombre del usuario autenticado
            $nombreUsuario = $usuarioAutenticado->name;
        
            // Verificar si el usuario tiene roles asignados antes de acceder al primer rol
            if ($usuarioAutenticado->roles->isNotEmpty()) {
                $rolUsuario = $usuarioAutenticado->roles->first()->name;
            } else {
                $rolUsuario = 'Sin roles asignados';
            }
        } else {
            $nombreUsuario = '';
            $rolUsuario = '';
        }

        // Si se solicita generar un PDF, entonces se generará y se enviará
        if ($request->has('generar_pdf')) {
            //pasamos datos
            $data = [
                'cursos' => $cursos,
                'sumaCursos' => $sumaCursos,
                'fecha_actual' => $fecha_actual,
                'hora_actual' => $hora_actual,
                'nombreUsuario' => $nombreUsuario,
                'rolUsuario' => $rolUsuario,
                'fechaFormateadaInicio' => $fechaFormateadaInicio,
                'fechaFormateadaFin' => $fechaFormateadaFin,
            ];

            // Generar el PDF con dompdf
            $pdf = Pdf::loadView('cursos.pdf', $data);

            // Mostrar el PDF en el navegador
            return $pdf->stream('Cursos.pdf');
        }

        return view('cursos.index', compact('cursos', 'sumaCursos'));
    }
    //pdf personalizado
    public function pdfPersonal($id)
    {
        $curso = Curso::findOrFail($id);

        $path_to_image = 'imagenesApoyo/logo-ludeno.svg';
        $type = pathinfo($path_to_image, PATHINFO_EXTENSION);
        $data = file_get_contents($path_to_image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $data = [
            'curso' => $curso,
            'base64Image' => $base64,
        ];

        $pdf = PDF::loadView('cursos.pdfPersonal', $data);

        return $pdf->stream('Recibo-cursos' . $id . '.pdf');
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
            $nombreCurso = $curso->Nombre_de_persona_pago_total;

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
