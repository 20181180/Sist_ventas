<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use App\Models\Meripuntos;

class ClientesController extends Component
{
    public $search, $name, $debt, $efectivo, $tipopago, $direc, $tel, $correo, $selected_id, $pageTitle, $componentName, $saldo, $limite;

    private $pagination = 10;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
        $this->tipopago = 0;
        $this->debt = 0;
        $this->efectivo = 0;
    }

    public function render()
    {

        if (strlen($this->search) > 0) {
            $data = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
                ->select('*',)
                ->where('clientes.name', 'like', '%' . $this->search . '%')
                ->where('clientes.estado', 'activo')
                ->paginate($this->pagination);
        } else {
            $data = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
                ->where('clientes.estado', 'activo')
                ->select('*',)->paginate($this->pagination);
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
        $this->emit('show-modal', 'infomacion del cliente');
    }
    public function Pay(Cliente $id)
    {

        $d = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->select('*',)
            ->where('clientes.id', '=', $id->id)
            ->first();

        $this->name = $d->name;
        $this->direc = $d->address;
        $this->selected_id = $d->client_id;

        $this->saldo = $d->saldo;
      //  $this->debt = $d->saldo;

        //nos permite mostrar el modal con el elemento.
        $this->emit('abono-client', 'Abono del cliente');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required',
            'direc' => 'required',
            'tel' => 'required|max:10',
            'correo' => 'required|email',
            'limite' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo valido',
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
            'saldo' => '0',
            'abono' => '0',
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
            'limite' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre es obligatorio',
            'direc.required' => 'Direccion obligatorio',
            'tel.required' => 'Ingrese un telefono',
            'tel.max' => 'Numero a digitos',
            'correo.required' => 'El campo correo es obligatorio',
            'correo.email' => 'Ingrese un correo valido',
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
        $meri = Meripuntos::where('client_id', '=', $this->selected_id)->first();
        $meri->update([
            'saldo' => $this->saldo,
            'limite' => $this->limite,
        ]);

        $this->resetUI();
        $this->emit('item-updated', 'Datos Actualizados');
    }


    public function goPay()
    {
        $category = Meripuntos::Where('client_id', '=', $this->selected_id)->first();

        if ($category->saldo > 0) {
            if ($this->tipopago == 1) {
                // $category = Meripuntos::Where('client_id', '=', $this->selected_id)->first();
                $sald = $category->saldo - $this->efectivo;
                $ab = $category->abono + $this->efectivo;
                $category->update([
                    'saldo' => $sald,
                    'abono' => $ab,
                ]);
            } else {
                //  $category = Meripuntos::Where('client_id', '=', $this->selected_id)->first();
                $sald = 0;
                $ab = $category->abono + $category->saldo;
                $category->update([
                    'saldo' => $sald,
                    'abono' => $ab,
                ]);
            }
            $this->resetUI();
            $this->emit('Abono-uwu', 'Abono Procesado');
        } else {
            //$this->emit('Abono-uwu', 'Lo sentimos no se puede completar el proceso :/');
            $this->resetUI();
            $this->emit('sale-error', 'Lo sentimos no se puede completar el proceso :/');
            return;
        }
    }


    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Cliente $clien)
    {


        $d = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->select('m.saldo',)
            ->where('clientes.id', '=', $clien->id)
            ->first();

        $estado = 'inactivo';
        if($d->saldo > 0)
        {
        $this->emit('item-deleted', 'No puede inactivarse: el cliente tiene deudas');
        return;
        }else{
            $clien->update([
                'estado' => $estado,
            ]);

            $this->resetUI();
            $this->emit('item-deleted', 'Cliente inactivado');
            return;
        }

    }


    public function resetUI()
    {
        $this->name = '';
        $this->direc = '';
        $this->tel = '';
        $this->correo = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->efectivo = 0;
        $this->tipopago = 0;
    }
}
