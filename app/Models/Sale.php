<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'items', 'dinero', 'cambio', 'estado', 'user_id', 'client_id', 'tipo_pago','direccion','tipoVenta'];
}
