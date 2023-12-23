<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//eliminacion
use Illuminate\Database\Eloquent\SoftDeletes;

class Alquilere extends Model
{
    use HasFactory;
    //eliminacion suave
    use SoftDeletes;

    protected $fillable = ['Nombre_de_persona_o_empresa', 'Detalle', 'Modulos', 'Plataforma', 'Retraso_de_entrega', 'Nro_de_comprobante', 'Ingresos'];

    //para la creacion automatica de las facturas 
    protected static function boot()
    {
        parent::boot();

        static::created(function ($alquilere) {
            $alquilere->Nro_de_comprobante = 'AA-' . str_pad($alquilere->id, 4, '0', STR_PAD_LEFT);
            $alquilere->save();
        });
        static::saving(function ($alquilere) {
            if (!$alquilere->Nro_de_comprobante) {
                $alquilere->Nro_de_comprobante = 'AA-' . str_pad($alquilere->id, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
