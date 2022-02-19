<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class CotizacionController extends Controller

{

    public function reportPDF($total,$items){
        $data = [];

        $data = Cart::getContent()->sortBy('name');
        $user = Auth::user()->name;



        $pdf = PDF::loadView('pdf.cotizacion', compact('data', 'total', 'items', 'user'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');



    }

}
