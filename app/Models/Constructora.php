<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//eliminacion
use Illuminate\Database\Eloquent\SoftDeletes;

class Constructora extends Model
{
    use HasFactory;
    //eliminacion suave
    use SoftDeletes;

    protected $fillable = ['Nro_de_comprobante','Dueño_de_la_obra', 'Direccion_de_la_obra', 'Fecha_inicio_de_Obra', 'Fecha_fin_de_Obra', 'Costo'];

    //para la creacion automatica de las facturas 
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($constructora) {
            $lastId = static::max('id') ?? 0; // Obtener el último ID en la tabla (o cero si no hay registros)
            $newId = $lastId + 1; // Incrementar el ID
            $constructora->Nro_de_comprobante = 'CL-' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        });
    }
}

