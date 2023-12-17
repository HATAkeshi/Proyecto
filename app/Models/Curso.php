<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_de_persona', 'Porcentaje_de_anticipo', 'Nombre_de_persona_pago_total', 'Detalle_de_curso', 'Numero_de_comprobante', 'metodo_pago', 'Ingresos'];

    // Relacion de uno a uno
    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'curso_id');
    }

    //para la creacion automatica de las facturas 
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($curso) {
            $lastId = static::max('id') ?? 0; // Obtener el último ID en la tabla (o cero si no hay registros)
            $newId = $lastId + 1; // Incrementar el ID
            $curso->Numero_de_comprobante = 'CCS-' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        });
    }
}
