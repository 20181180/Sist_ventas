<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Product;
use Livewire\Component;
use App\Models\Informacion;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class InformesController extends Component
{
    public $deu, $m, $prod_bj, $prod_exi, $catg_p, $estado;

    public function mount()
    {
        $this->deu = [];
        $this->estado = 0;
        $this->prod_bj = [];
        $this->prod_exi = [];
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
    public function GeneratePDF()
    {
        $data = [];
        $data = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->where('stock', '<', 1)->get();
        $infoE = Informacion::where('id', 1)->first();

        $user = Auth::user()->name; //cambiar a auth()
        $fecha = Carbon::now();
        $pdf = PDF::loadView('pdf.produc_baj', compact('data', 'infoE', 'user'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');
    }

    public function catalogoP_PDF()
    {
        $data = [];
        $data = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')->get();

        $user = Auth::user()->name; //cambiar a auth()
        $fecha = Carbon::now();

        $infoE = Informacion::where('id', 1)->first();

        $pdf = PDF::loadView('pdf.catalogo', compact('data', 'user', 'infoE'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');
    }
}
