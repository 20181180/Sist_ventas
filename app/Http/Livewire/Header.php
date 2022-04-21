<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Informacion;

class Header extends Component
{
    public $nombre;
    public function render()
    {
        // $data = Informacion::select('*')->get();
        // //dd($data);
        // $image = $data->image;
        // $this->nombre = $data->empresa;
        // $nombre = $this->nombre;

        return view('layouts.theme.app');
    }
}
