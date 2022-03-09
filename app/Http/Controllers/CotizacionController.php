<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\User;
use App\Models\Cotizaciones;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CotizacionController extends Controller

{

    public function reportPDF($total, $items)
    {
        $data = [];

        $data = Cart::getContent()->sortBy('name');
        $user = Auth::user()->name;

        $fecha = Carbon::now();
        $fechaV = $fecha->addDays(15);
        $fechaV->toFormattedDateString(); 


        $clav_id = Str::random(10);


        foreach ($data as $criterio) {
            $id_var = $criterio->id;
            $precio = $criterio->price;
            $cantid = $criterio->quantity;
            $nom = $criterio->name;

            $contizaciones = Cotizaciones::create([
                'total' => $items,
                'price' => $precio,
                'quantity' => $cantid,
                'clave_id' => $clav_id,
                'name' => $nom,
                'expiration_date' => $fechaV,
            ]);
        }

        $pdf = PDF::loadView('pdf.cotizacion', compact('data', 'total', 'items', 'user'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');
    }
}
