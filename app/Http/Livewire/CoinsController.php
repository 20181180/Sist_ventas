<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; //sirve para subir imagenes
use Livewire\WithPagination;
use App\Models\Denomination;

class CoinsController extends Component
{

    use WithFileUploads;
    use WithPagination;

    //declaracion de varibales
    public $type, $value, $search, $image, $selected_id, $pageTitle, $componentName;

    private $pagination = 4;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->type ='Elegir';
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Denomination::Where('type', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Denomination::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.denominations.component', ['data' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = Denomination::find($id, ['id', 'type', 'value', 'image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;
        //nos permite mostrar el modal con el elemento.
        $this->emit('show-modal', 'show modal');
    }

    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations'
        ];

        $messages = [
            'type.required' => 'El tipo obligatorio',
            'type.not_in' => 'Elige un valor para el tipo distinto a Elegir',
            'value.required' => 'El valor obligatorio',
            'value.unique' => 'El valor que ingreso ya esta registrado'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Denominacion registrado xd');
    }

    public function Update()
    {
        $rules = [
            'type' => "required|not_in:Elegir",
            'value' => "required|unique:denominations,value,{$this->selected_id}"
        ];
        $messages = [
            'type.required' => 'El tipo obligatorio',
            'type.not_in' => 'Elige un tipo valido',
            'value.required' => 'El valor obligatorio',
            'value.unique' => 'El valor que ingreso ya esta registrado'
        ];
        $this->validate($rules, $messages);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            if ($imageName != null) {
                if (file_exists('storage/denominations/' . $imageName)) {
                    unlink('storage/denominations/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Denominacion Actualizada');
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination)
    {
        //$category = Category::find($id);
        $imageName = $denomination->image;
        $denomination->delete();

        if ($imageName != null) {
            unlink('storage/denominations/' . $imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Denominacion Eliminada');
    }

    public function resetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
