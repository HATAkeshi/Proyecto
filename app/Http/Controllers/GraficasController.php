<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//modelo
use App\Models\Ingresoegreso;

class GraficasController extends Controller
{
    //aqui las graficas de ingresos egresos en la vista de dashboard
    public function graficasIngresosEgresos()
    {
        // Obtener los datos de la base de datos
        $ingresosEgresos = IngresoEgreso::all(); 

        // Preparar los datos para la gráfica
        $fechas = $ingresosEgresos->pluck('fecha')->map(function ($fecha) {
            return \DateTime::createFromFormat('Y-m-d', $fecha); // Convertir la cadena a objeto DateTime
        })->toArray();

        $ingresos = $ingresosEgresos->pluck('Ingreso')->map(function ($ingreso) {
            return (float) $ingreso; // Convertir los ingresos a valores flotantes
        })->toArray();

        $egresos = $ingresosEgresos->pluck('Egreso')->map(function ($egreso) {
            return (float) $egreso; // Convertir los egresos a valores flotantes
        })->toArray();

        // Puedes enviar estos datos a tu vista
        return view('dashboard', compact('fechas', 'ingresos', 'egresos'));
    }
}
