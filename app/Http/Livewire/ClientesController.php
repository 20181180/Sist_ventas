<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use App\Models\Meripuntos;

class ClientesController extends Component
{
    public $search, $name, $direc, $tel, $correo, $selected_id, $pageTitle, $componentName, $saldo, $limite;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
    }

    public function render()
    {

        if (strlen($this->search) > 0)
        {
            // $data = Cliente::Where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
           // $data = Meripuntos::join('clientes as c', 'c.id', 'meripuntos.client_id')
            $data = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->select('*',)
            ->where('clientes.name', 'like', '%' . $this->search . '%')
            ->paginate($this->pagination);

        }else{
            $data = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->select('*',)->paginate($this->pagination);
           // $data = Cliente::orderBy('id', 'desc')->paginate($this->pagination);
        }


        return view('livewire.clients.clientes', ['cliente' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit(Cliente $id)
    {

        $d = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->select('*',)
            ->where('clientes.id', '=', $id->id)
            ->first();

            $this->name = $d->name;
            $this->direc = $d->address;
            $this->selected_id = $d->client_id;
            $this->tel = $d->phone;
            $this->correo = $d->email;
            $this->saldo = $d->saldo;
            $this->limite = $d->limite;

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
            'saldo' => 'required',
            'limite' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo valido',
            'saldo.required' => 'El campo saldo es requerido',
            'limite.required' => 'El campo limite es requerido',
        ];

        $this->validate($rules, $messages);

        $clien = Cliente::create([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'email' => $this->correo,
        ]);

        $cliente = Cliente::select('id')->orderBy('id', 'desc')->first();


            $cuenta = Meripuntos::create([
                'saldo' => $this->saldo,
                'limite' => $this->limite,
                'meripuntos' => '0',
                'client_id' => $cliente->id,
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
            'saldo' => 'required',
            'limite' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo valido',
            'saldo.required' => 'El campo saldo es requerido',
            'limite.required' => 'El campo limite es requerido',
        ];

        $this->validate($rules, $messages);



        $clien = Cliente::find($this->selected_id);
        $clien->update([
            'name' => $this->name,
            'address' => $this->direc,
            'phone' => $this->tel,
            'email' => $this->correo,
        ]);
        $meri = Meripuntos::where('client_id', '=' ,$this->selected_id)->first();
        $meri->update([
            'saldo' => $this->saldo,
            'limite' => $this->limite,
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

