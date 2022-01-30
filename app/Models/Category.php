<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    ///aqui se pondran las categorias
    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute(){
        if ($this->image != null)
            return (file_exists('storage/categories/' . $this->image) ? 'categories/' . $this->image : 'img_no.jpg');
         else 
            return 'img_no.jpg';
    }

}

