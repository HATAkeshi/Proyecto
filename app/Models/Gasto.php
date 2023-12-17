<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;
    protected $fillable = ['Motivo_resumido_de_salida_de_dinero', 'Nombre_a_quien_se_entrego_el_dinero', 'Quien_aprobo_la_entrega_de_dinero', 'Nro_de_comprobante', 'Monto'];

    //para la creacion automatica de las facturas 
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gasto) {
            $lastId = static::max('id') ?? 0; // Obtener el último ID en la tabla (o cero si no hay registros)
            $newId = $lastId + 1; // Incrementar el ID
            $gasto->Nro_de_comprobante = 'G-' . str_pad($newId, 5, '0', STR_PAD_LEFT);
        });
    }
}
