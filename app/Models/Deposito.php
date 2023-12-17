<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//eliminacion
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposito extends Model
{
    use HasFactory;
    //eliminacion suave
    use SoftDeletes;
    
    protected $fillable = ['Nro_de_transaccion', 'Nombre', 'Monto'];

    // Definición de la relación con Curso
    public function cursos()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
