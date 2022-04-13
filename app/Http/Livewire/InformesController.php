<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Product;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;

class InformesController extends Component
{
    public $deu, $m, $prod_bj, $prod_exi,$catg_p, $estado;
    public function mount()
    {
        $this->deu = [];
        $this->estado = 0;
        $this->prod_bj = [];
        $this->prod_exi=[];
    }
    public function render()
    {
        return view('livewire.informe.informes', [
            'products' => Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')

                ->orderBy('products.stock', 'asc')->get(),

        ])->extends('layouts.theme.app')
            ->section('content');
    }


    public function GeneratePDF()
    {
        $data = [];
        $data = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->where('stock', '<', 1)->get();

        $user = 'juan'; //cambiar a auth()
        $fecha = Carbon::now();
        $pdf = PDF::loadView('pdf.produc_baj', compact('data'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');
    }

    public function client_deud()
    {
        // $this->deu = Cliente::where('estado', '>', 0)->get();
        $this->deu = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->where('clientes.estado', 'activo')
            ->where('saldo', '>', 0)->get();
        $this->estado = 1;
    }

    public function meri()
    {
        // $this->deu = Cliente::where('estado', '>', 0)->get();
        $this->deu = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->where('clientes.estado', 'activo')
            ->where('meripuntos', '>', 0)->get();
        $this->estado = 2;
    }

    public function pro_bajos()
    {
        $this->prod_bj = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->where('stock', '<', 1)->get();
        $this->estado = 3;
    }
    public function pro_exis()
    {
        $this->prod_exi = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->where('stock', '>=', 1)->get();
        $this->estado = 4;
    }
}
