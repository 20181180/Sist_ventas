<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;

class ClientesController extends Component
{
    public $search, $name, $direc, $tel, $correo, $selected_id, $pageTitle, $componentName;

    private $pagination = 4;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Cliente::Where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Cliente::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.clients.clientes', ['cliente' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $clien = Cliente::find($id, ['id', 'name', 'address', 'phone', 'email']);
        $this->name = $clien->name;
        $this->direc = $clien->address;
        $this->selected_id = $clien->id;
        $this->tel = $clien->phone;
        $this->correo = $clien->email;
        //nos permite mostrar el modal con el elemento.
        $this->emit('show-modal', 'Informacion del cliente');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required',
            'direc' => 'required',
            'tel' => 'required|max:10',
            'correo' => 'required|email',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo valido',
        ];

        $this->validate($rules, $messages);

        $clien = Cliente::create([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'email' => $this->correo,
        ]);

        $this->resetUI();
        $this->emit('pro-added', 'Cliente Registrado con Exito.');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|unique:companies,name,{$this->selected_id}",
            'direc' => 'required',
            'tel' => 'required|max:10',
            'correo' => 'required|email',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo valido',
        ];

        $this->validate($rules, $messages);

        $clien = Cliente::find($this->selected_id);
        $clien->update([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'email' => $this->correo,
        ]);

        $this->resetUI();
        $this->emit('item-updated', 'Datos Actualizados');
    }


    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Cliente $clien)
    {
        //$category = Category::find($id);

        $clien->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Cliente Eliminada');
    }


    public function resetUI()
    {
        $this->name = '';
        $this->direc = '';
        $this->tel = '';
        $this->correo = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}