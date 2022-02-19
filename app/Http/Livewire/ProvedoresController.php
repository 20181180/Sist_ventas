<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company;

class ProvedoresController extends Component
{

    use WithPagination;

    //declaracion de varibales
    public $search, $name, $direc, $tel, $empresa, $selected_id, $pageTitle, $componentName;

    private $pagination = 4;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Proveedores';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Company::Where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Company::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.proveedor.componet', ['proveedor' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = Company::find($id, ['id', 'name', 'address', 'phone', 'taxpayer_id']);
        $this->name = $record->name;
        $this->direc = $record->address;
        $this->selected_id = $record->id;
        $this->tel = $record->phone;
        $this->empresa = $record->taxpayer_id;
        //nos permite mostrar el modal con el elemento.
        $this->emit('show-modal', 'show modal');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required',
            'direc' => 'required',
            'tel' => 'required|max:10',
            'empresa' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
        ];

        $this->validate($rules, $messages);

        $companie = Company::create([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'taxpayer_id' => $this->empresa,
        ]);

        $this->resetUI();
        $this->emit('pro-added', 'Provedor Registrado con Exito.');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:companies,name,{$this->selected_id}",
            'direc' => 'required',
            'tel' => 'required|max:10',
            'empresa' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El valor que ingreso ya esta registrado',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
        ];

        $this->validate($rules, $messages);

        $companie = Company::find($this->selected_id);
        $companie->update([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'taxpayer_id' => $this->empresa,
        ]);



        $this->resetUI();
        $this->emit('item-updated', 'Datos Actualizados');
    }


    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Company $companie)
    {
        //$category = Category::find($id);

        $companie->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Denominacion Eliminada');
    }


    public function resetUI()
    {
        $this->name = '';
        $this->direc = '';
        $this->tel = '';
        $this->empresa = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
