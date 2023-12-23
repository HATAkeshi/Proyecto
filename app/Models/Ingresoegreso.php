<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresoegreso extends Model
{
    use HasFactory;
    protected $fillable = ['Detalle', 'Nombre', 'Ingreso', 'Egreso', 'Saldo', 'fecha'];

    //para guardar valores por defecto 
    protected $attributes = [
        'Ingreso' => 0, // Establece un valor predeterminado para 'Egreso'
        'Egreso' => 0, // Establece un valor predeterminado para 'Saldo'
    ];
}
