<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_de_persona_anticipo_y_porcentaje_de_anticipo', 'Nombre_de_persona_pago total', 'Detalle_de_curso', 'Numero_de_comprobante', 'Ingresos'];

    // Relacion de uno a uno
    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'curso_id');
    }
}
