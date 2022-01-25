<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //sirve para subir imagenes
use Livewire\WithPagination;
use App\Models\Category;

class CategoriesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    //declaracion de varibales
    public $name, $search, $image, $selected_id, $pageTitle, $componentName;

    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function render()
    {
        $data = Category::all();
        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
