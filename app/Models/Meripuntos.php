<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meripuntos extends Model
{
    use HasFactory;
    protected $fillable = ['saldo','limite','meripuntos', 'client_id'];
}
