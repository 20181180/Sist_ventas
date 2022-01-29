<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;

class CoinsController extends Component
{

    public $componentName, $pageTitle, $selected_id, $image, $search, $type;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->selected_id = 0;
        //$this->image = null;
    }
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        return view(
            'livewire.denominations.component',
            [
                'data' => Denomination::paginate(5)
            ]
        )->extends('layouts.theme.app')->section('content');
    }



    public function resetUI()
    {
    }
}
