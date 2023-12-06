<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;
    protected $fillable = ['Motivo_resumido_de_salida_de_dinero', 'Nombre_a_quien_se_entrego_el_dinero', 'Quien_aprobo_la_entrega_de_dinero', 'Nro_de_comprobante', 'Monto'];
}
