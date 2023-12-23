<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//eliminacion
use Illuminate\Database\Eloquent\SoftDeletes;

class Gasto extends Model
{
    use HasFactory;
    //eliminacion suave
    use SoftDeletes;

    protected $fillable = ['Motivo_resumido_de_salida_de_dinero', 'Nombre_a_quien_se_entrego_el_dinero', 'Quien_aprobo_la_entrega_de_dinero', 'Nro_de_comprobante', 'Monto'];

    //para la creacion automatica de las facturas 
    protected static function boot()
    {
        parent::boot();

        static::created(function ($gasto) {
            $gasto->Nro_de_comprobante = 'G-' . str_pad($gasto->id, 5, '0', STR_PAD_LEFT);
            $gasto->save();
        });
        static::saving(function ($gasto) {
            if (!$gasto->Nro_de_comprobante) {
                $gasto->Nro_de_comprobante = 'AA-' . str_pad($gasto->id, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
