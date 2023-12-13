<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//modelos
use App\Models\Curso;
use App\Models\Alquilere;
use App\Models\Ingresoegreso;
use App\Models\Gasto;
use Carbon\Carbon;

class UpdateIngresoEgresoDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-ingreso-egreso-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualización diaria del ingreso y egreso';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fechaActual = now();

        //vemos si ya existe el registro y si es haci lo actualizamos en ves de crear uno nuevo 
        $registroActual = Ingresoegreso::where('fecha', $fechaActual)->first();

        // Calcula la suma de Cursos y Alquileres
        $sumaCursosActual = Curso::whereDate('created_at', $fechaActual)->sum('Ingresos');
        $sumaAlquileresActual = Alquilere::whereDate('created_at', $fechaActual)->sum('Ingresos');
        
        //egreso
        $sumaGastosActual = Gasto::whereDate('created_at', $fechaActual)->sum('Monto');

        //saldo del dia anterior 
        $saldoDiaAnterior = Ingresoegreso::whereDate('fecha', today()->subDay())->value('Ingreso');

        //ingresos
        //suma total de la tala cursos y alquileres y ademas es
        //saldo final del dia
        $sumaCursosAlquileresAnteriorActual = $sumaCursosActual + $sumaAlquileresActual + $saldoDiaAnterior;

        if ($registroActual) {
            //ingreso
            $registroActual->Ingreso = $sumaCursosAlquileresAnteriorActual;
            //egreso
            $registroActual->Egreso = $sumaGastosActual;
            //saldo
            $registroActual->Saldo = $sumaCursosAlquileresAnteriorActual - $sumaGastosActual;
            //guardamos
            $registroActual->save();
        } else {
            //ingreso
            $sumaTotal = 0;
            //egreso
            $sumaGasto = 0;
            //saldo
            $sumaSaldo = 0;
            // Guarda la suma en la tabla Ingresoegresos
            $nuevoRegistro = new Ingresoegreso();
            $nuevoRegistro->fecha = $fechaActual;
            $nuevoRegistro->Ingreso = $sumaTotal;
            $nuevoRegistro->Egreso = $sumaGasto;
            $nuevoRegistro->Saldo = $sumaTotal - $sumaGasto;
            $nuevoRegistro->save();
        }

        // Verifica si existe un registro para el día siguiente
        $siguienteRegistro = Ingresoegreso::where('fecha', $fechaActual->copy()->addDay()->toDateString())->first();

        if (!$siguienteRegistro) {
            // Crea un nuevo registro para el día siguiente con valores predeterminados
            $nuevoRegistro = new Ingresoegreso();
            $nuevoRegistro->fecha = $fechaActual->copy()->addDay()->toDateString();
            $nuevoRegistro->Ingreso = 0;
            $nuevoRegistro->Egreso = 0;
            $nuevoRegistro->Saldo = 0;
            $nuevoRegistro->save();
        }
    }
}


