<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    use HasFactory;
    protected $fillable = ['total', 'price', 'quantity', 'clave_id', 'name', 'expiration_date','id_produc'];
}
