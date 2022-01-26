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

    private $pagination = 2;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Category::Where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
