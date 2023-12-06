<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquilere extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_de_persona_o_empresa', 'Detalle', 'Modulos', 'Plataforma', 'Retraso_de_entrega', 'Nro_de_comprobante', 'Ingresos'];
}
