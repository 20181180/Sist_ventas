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

    private $pagination = 4;

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

    public function Edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;
        //nos permite mostrar el modal con el elemento.
        $this->emit('show-modal', 'show modal');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'Categoria Obligatorio',
            'name.unique' => 'Verifique que no exista la categoria',
            'name.min' => 'Ingrese minimo 3 caracteres para el nombre de la categoria'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        $customFileName;
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'Categoria registrado xd');
    }

    public function Update(){
        $rules =[
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'Categoria Obligatorio',
            'name.unique' => 'El nombre de la categoria ya existe',
            'name.min' => 'Ingrese minimo 3 caracteres para el nombre de la categoria'
        ];
        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if ($this->image)
         {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();
            if($imageName !=null){
                if(file_exists('storage/categories/' . $imageName)){
                    unlink('storage/categories/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('category-updated', 'categoria Actualizada');
    }
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Category $category){
        //$category = Category::find($id);
        $imageName = $category->image;
        $category->delete();

        if($imageName !=null){
            unlink('storage/categories/' . $imageName);

        }

        $this->resetUI();
        $this->emit('category-deleted', 'Categoria Eliminada');

    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
