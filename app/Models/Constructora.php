<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constructora extends Model
{
    use HasFactory;
    protected $fillable = ['Dueño_de_la_obra', 'Direccion_de_la_obra', 'Fecha_inicio_de_Obra', 'Fecha_fin_de_Obra', 'Costo'];
}
