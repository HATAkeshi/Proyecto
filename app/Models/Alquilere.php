<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquilere extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_de_persona_o_empresa', 'Detalle', 'Modulos', 'Plataforma', 'Retraso_de_entrega', 'Nro_de_comprobante', 'Ingresos'];

    //para la creacion automatica de las facturas 
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($alquilere) {
            $lastId = static::max('id') ?? 0; // Obtener el último ID en la tabla (o cero si no hay registros)
            $newId = $lastId + 1; // Incrementar el ID
            $alquilere->Nro_de_comprobante = 'AA-' . str_pad($newId, 5, '0', STR_PAD_LEFT);
        });
    }
}
