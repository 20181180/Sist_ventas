<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Informacion;
use Illuminate\Support\Str;
use App\Models\Cotizaciones;
use Illuminate\Http\Request;
use Hamcrest\Core\HasToString;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CotizacionController extends Controller

{

    public function reportPDF($total, $items, $points)
    {
        $data = [];

        $data = Cart::getContent()->sortBy('name');
        $user = Auth::user()->name;

        $fecha = Carbon::now();
        $fechaV = $fecha->addDays(15);
        $fechaV->toFormattedDateString();
        $clav  = Carbon::now()->format('d-M-Y');
        $fined_id = Cotizaciones::latest('id')->first();
        $infoE = Informacion::where('id', 1)->first();

        if (empty($fined_id)) {
            $clav_id =  "01" . '/' . "$clav";
        } else {
            $id = $fined_id->id;
            $clav_id =  "$id" . '/' . "$clav";
        }


        // dd($clav);

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
                'id_produc' => $id_var,
            ]);
        }

        $pdf = PDF::loadView('pdf.cotizacion', compact('data', 'total', 'items', 'user', 'clav_id', 'fechaV', 'points', 'infoE'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');
    }
}
