<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//modelos involucrados 
use App\Models\Curso;
use App\Models\Alquiler;

class ActualizarSaldoInicial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:actualizar-saldo-inicial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar la variable sumada de Curso y Alquilere y congelar a su ves';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //logica
        
    }
}
