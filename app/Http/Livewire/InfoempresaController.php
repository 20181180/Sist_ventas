<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Informacion;

class InfoempresaController extends Component
{
    public function render()
    {
        $infoE = Informacion::where('id', 1)->first();

        return view('livewire.infoempresa-controller',['infoE' => $infoE] );
    }
}
