<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresoegreso extends Model
{
    use HasFactory;
    protected $fillable = ['Detalle', 'Nombre', 'Ingreso', 'Egreso', 'Saldo', 'fecha'];
}
