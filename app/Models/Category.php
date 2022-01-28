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
        if($this->image==null){
            return 'logo.png';
        }
        else if(file_exists('storage/categories/' . $this->image))
           {
               return $this->image;
            }
        else
            {
                return 'logo.png';
            }
    }

}
