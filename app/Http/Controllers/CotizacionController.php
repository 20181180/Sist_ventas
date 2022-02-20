<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\User;
use App\Models\Cotizaciones;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class CotizacionController extends Controller

{

    public function reportPDF($total, $items)
    {
        $data = [];



        $data = Cart::getContent()->sortBy('name');
        $user = Auth::user()->name;
        /*
        for ($i = 0; $i <= $data . ob_get_length(); $i++) {

            $hola = Cart::getContent()->items;
            $hola2 = Cart::getContent()->price;
            dd($hola);
            dd($hola2);
        }*/

        foreach ($data as $criterio) {
            $id_var = $criterio->id;
            $precio = $criterio->price;
            $cantid = $criterio->quantity;
            $nom = $criterio->name;

            $contizaciones = Cotizaciones::create([
                'total' => $items,
                'price' => $precio,
                'quantity' => $cantid,
            ]);
        }






        $pdf = PDF::loadView('pdf.cotizacion', compact('data', 'total', 'items', 'user'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');
    }
}
