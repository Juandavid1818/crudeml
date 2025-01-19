<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    // Definimos los campos que son asignables masivamente
    protected $fillable = ['foto', 'nombres', 'apellidos', 'telefono', 'estado', 'fecha_registro'];


}
