<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    use HasFactory;
    protected $fillable = ['Nro_de_transaccion', 'Nombre', 'Ingresos'];

    // Definición de la relación con Curso
    public function cursos()
    {
        return $this->belongsTo(Curso::class);
    }
}
