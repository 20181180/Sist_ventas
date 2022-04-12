<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Product;
use Livewire\Component;
use Barryvdh\DomPDF\Facade as PDF;

class InformesController extends Component
{
    public function render()
    {
        return view('livewire.informe.informes', [
            'products' => Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('stock', '<', 1)
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

        //Cart::clear(); //limpiamos e inicializamos las varibles..
    }
}
