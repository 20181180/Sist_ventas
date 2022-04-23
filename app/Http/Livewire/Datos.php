<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Informacion;
use Livewire\WithFileUploads;

class Datos extends Component
{
    use WithFileUploads;

    public  $direc, $tel, $empresa, $image, $cp, $face, $correo;

    public function render()
    {
        return view('livewire.datos', [
            'inf' => Informacion::orderBy('id', 'desc')->get(),

        ])

            ->extends('layouts.theme.app')
            ->section('content');

        // return view('livewire.datos', [
        //     'inf' => Informacion::orderBy()->get(),
        // ])
        //     ->extends('layouts.theme.app')
        //     ->section('content');
    }

    public function mount()
    {
        $this->direc = '';
        $this->tel = '';
        //  $this->image = null;
        $this->empresa = '';
        $this->face = '';
        $this->correo = '';

        $this->cp = '';
    }

    public function Store()
    {
        //dd('hola');
        $rules = [
            'empresa' => 'required|unique:Informacions|min:3',
            'direc' => 'required',
            'tel' => 'required',
            'cp' => 'required',
            'correo' => 'required',
            'image' => 'required',
        ];

        $messages = [
            'empresa.required' => 'Lo sentimos el nombre es obligatorio *',
            'empresa.min' => 'Ingrese minimo 3 caracteres para el nombre *',
            'direc.required' => 'Costo Obligatorio *',
            'tel.required' => 'Telefono requerido *',
            'cp.required' => 'Ingrese un CP',
            'correo.required' => 'Correo obligatorio*',
            'image.required' => 'Obligatorio *',

        ];

        $this->validate($rules, $messages);
        // //metdo de crear el producto

        $product = Informacion::create([
            'empresa' => $this->empresa,
            'ubicacion' => $this->direc,
            'tel' => $this->tel,
            'codigopostal' => $this->cp,
            'correo' => $this->correo,
            'face' => $this->face,

        ]);
        //  $customFileName;
        if ($this->image) {
            //dd($this->image);
            $ex = '.' . $this->image->extension();
            // dd($ex);
            if ($ex == '.jpg' || $ex == '.png') {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/datos', $customFileName);
                $product->image = $customFileName;
                $product->save();
            } elseif ($ex != 'jpg' || $ex != 'png') {
                // $this->resetUI();
                $this->emit('product-no', 'verifique el formato de la imagen, por el momento se a sustituido por un imagen por defecto');
                return;
            }
        }

        $this->resetUI();
        $this->emit('inf-added', 'Informacion Registrado');
    }

    public function resetUI()
    {
        # code...
        $this->direc = '';
        $this->tel = '';
        //  $this->image = null;
        $this->empresa = '';
        $this->face = '';
        $this->correo = '';

        $this->cp = '';
    }
}
