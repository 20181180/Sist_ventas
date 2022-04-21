<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacion extends Model
{
    use HasFactory;
    protected $fillable = ['empresa', 'correo', 'image', 'tel', 'face', 'ubicacion', 'codigopostal'];
}
