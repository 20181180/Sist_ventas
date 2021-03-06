<?php

namespace App\Http\Livewire;

use Exception;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Cliente;
use App\Models\Product;
use Livewire\Component;
use App\Models\Meripuntos;
use App\Models\Informacion;
use App\Models\SaleDetails;
use App\Models\Cotizaciones;
//use Dompdf\JavascriptEmbedder;
use App\Models\Denomination;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
//anadi una prueva

class PosController extends Component
{
    public $direccion, $costo_envio, $tipoenvio, $cantis, $cangeo, $colorStock, $puntos1, $tipopago, $category, $datosxd, $datauwuxd, $cheked, $searchD, $search, $estadoCheck, $producId, $tipoVenta, $client_id, $total, $itemsQuantity, $efectivo, $change, $valiente, $meri, $puntos, $tipo_precio, $Modaltipo_precio;

    public function mount()
    {
        $this->tipoenvio = '0';
        $this->tipo_precio = 1;
        $this->cangeo = 0;
        $this->colorStock = '';
        $this->tipoVenta = 'Elegir';
        $this->category = [];
        $this->datosxd = [];
        $this->tipopago = 0;
        $this->datauwuxd = [];
        $this->client_id = 5;
        $this->estadoCheck = 'false';
        $this->cheked = '0';
        $this->efectivo = 0;
        $this->change = 0;
        $this->puntos1 = 0;
        $this->meri = 0;
        $this->costo_envio = 0;
        $this->total = Cart::getTotal();
        $this->puntos = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {


        $this->xdtotal();

        $cart = Cart::getContent()->sortBy('name');
        if (strlen($this->search) > 0)
            $data = Product::Where('name', 'like', '%' . $this->search . '%')->get();

        else
            $data = Product::orderBy('name', 'desc')->get();
        $dataD = [];

        foreach ($cart as $c) {

            $product = Product::find($c->id);
            if ($c->quantity >= $product->stock) {
                $c->marcado = 1;
            }
            if ($c->price == $product->price_mayoreo) {
                $c->checado = 1;
            }
            if ($c->price == $product->cost) {
                $c->checado = 1;
            }
        }

        $this->check_meripoints();



        $client = Cliente::join('meripuntos as m', 'm.client_id', 'clientes.id')
            ->select('*',)
            ->where('clientes.estado', 'activo')->get();



        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'products' => $data,
            'cotiza' => $dataD,
            'clientes' => $client,
            'cart' => $cart,
            'tipoventa' => $this->tipoVenta,


        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function pruebas()
    {
    }

    //el metodo a cash es para calcular el cambio
    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'ACashAmano' => 'ACashAmano',
        'cotizacion' => 'cotizar',
        'Canjear' => 'Meri',
    ];
    public function cotizar($searchD)
    {
        $dataD = Cotizaciones::Where('clave_id', $searchD)->get();
        $vali = (count($dataD) == 0);
        $fecha = Carbon::now();

        if ($vali == 'true') {
            $this->emit('scan-notfound', 'Clave de cotizacion no valido.');
            return;
        } else {
            $p = Cotizaciones::where('clave_id', $searchD)->first();
            if ($fecha >= $p->expiration_date) {
                $this->emit('scan-notfound', 'La cotizacion a expirado');
                return;
            }

            foreach ($dataD as $d) {
                $product = Product::where('id', $d->id_produc)->first();
                if ($d->price == $product->price) {
                    Cart::add($product->id, $product->name, $product->price, $d->quantity, $product->image);
                } else {
                    Cart::add($product->id, $product->name, $product->price_mayoreo, $d->quantity, $product->image);
                }
            }
            $this->total = Cart::getTotal();
            $this->puntos = (Cart::getTotal()) / 100 * 10;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Cotizacion Agregado..');
        }
    }
    public function ACashAmano($value)
    {

        $this->efectivo = ($value == 0 ? $this->total : $value);
        $this->total = Cart::getTotal() + $this->costo_envio;
        //dd($this->total);
        $this->change = ($this->efectivo - $this->total);
    }

    public function Abonar($value)
    {
        $this->efectivo = ($value == 0 ? $this->total : $value);
        $this->change = ($this->total - $this->efectivo);
    }
    //este evento es pra escanear el codigo de barras
    public function ScanCode($barcode, $cant)
    {


        $product = Product::where('barcode', $barcode)->orWhere('name', $barcode)->first();


        if ($product == null) {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        } else {

            if ($this->InCart($product->id)) {
                if ($this->Modaltipo_precio == 1) {
                    $this->estadoCheck = "true";
                } else if ($this->Modaltipo_precio == 2) {
                    $this->estadoCheck = "true";
                } else if ($this->Modaltipo_precio == 0) {
                    $this->estadoCheck = "false";
                }
                $this->increaseQty($product->id, $this->estadoCheck, $cant);
                return;
            }
            if ($product->stock < 1) {

                $this->emit('no-stock', 'Stock insuficiente :/');
                return;
            }

            if ($product->stock < $cant) {

                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
            if ($this->Modaltipo_precio == 1) {
                Cart::add($product->id, $product->name, $product->price_mayoreo, $cant, $product->image);
            } else if ($this->Modaltipo_precio == 2) {
                Cart::add($product->id, $product->name, $product->cost, $cant, $product->image);
            } else if ($this->Modaltipo_precio == 0) {
                Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            }


            $this->total = Cart::getTotal();
            $this->puntos = (Cart::getTotal()) / 100 * 10;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Producto agregado');
        }
    }
    //valida si el id del producto ya existe en el carrito
    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;
    }
    //actualiza la cantidad de la existencia del producto
    public function increaseQty($productId, $state, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad actualizada';
        else
            $title = 'Producto agregado';

        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity)) {

                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }
        // if ($state == 'true') {
        //     Cart::add($product->id, $product->name, $product->price_mayoreo, $cant, $product->image);
        // } else {

        //     Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        // }
        if ($state == 'true') {
            if ($this->tipo_precio == '1') {
                Cart::add($product->id, $product->name, $product->price_mayoreo, $cant, $product->image);
            } else {
                Cart::add($product->id, $product->name, $product->cost, $cant, $product->image);
            }
        } else {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        }
        $this->total = Cart::getTotal();
        $this->puntos = (Cart::getTotal()) / 100 * 10;
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);
    }

    public function incre_meri($productId, $cant = 1)
    {

        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad actualizada';
        else
            $title = 'Producto agregado';

        if ($exist) {
            if ($this->puntos < $product->price) {

                $this->emit('no-stock', 'puntos insuficiente :|');
                return;
            }
            if ($product->stock < ($cant + $exist->quantity)) {

                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }


        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();
        $this->p =  $this->puntos1 - $this->total;
        $this->puntos = $this->p;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);
    }

    //reemplaza el registro del carrito
    public function updateQty($productId, $state, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad actualizada';
        else
            $title = 'Producto agregado';
        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }

        $this->removeItem($productId);

        if ($cant > 0) {
            if ($state == 'true') {
                if ($this->tipo_precio == '1') {
                    Cart::add($product->id, $product->name, $product->price_mayoreo, $cant, $product->image);
                    $title = 'Mayoreo producto:';
                } else {
                    Cart::add($product->id, $product->name, $product->cost, $cant, $product->image);
                    $title = 'costo producto:';
                }
            } else {
                Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
                $title = 'Menudeo producto:';
            }
            $this->total = Cart::getTotal();
            $this->puntos = (Cart::getTotal()) / 100 * 10;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }

    public function xdtotal()
    {
        if ($this->tipoenvio == '1') {
            $this->total = Cart::getTotal() + $this->costo_envio;
        } else {
            $this->total = Cart::getTotal();
        }
    }
    //elimnar el producto del carrito
    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->puntos = (Cart::getTotal()) / 100 * 10;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }
    //disminuir la cantidad de los productos en el carrito
    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;

        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

        $this->total = Cart::getTotal();
        $this->puntos = (Cart::getTotal()) / 100 * 10;

        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad actualizada');
    }

    public function clearCart()
    {
        Cart::clear();
        $this->puntos1 = '';
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->puntos = Cart::getTotal();
        //     $this->client_id = 0;
        $this->tipopago = 0;
        $this->cangeo = 0;
        $this->client_id = 5;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vaciado...');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos...');
            return;
        }


        if (empty($this->client_id)) {
            $this->emit('sale-error', 'Favor de agregar un cliente.');
            return;
        }
        // if (empty($this->tipopago)) {
        //     $this->emit('sale-error', 'Favor de agrega un tipo de pago.');
        //     return;
        // }
        //transaccion a la bd para guardar la venta en detalles venta
        DB::beginTransaction();
        try {

            if ($this->tipopago == 0) {
                if ($this->efectivo <= 0) {
                    $this->emit('sale-error', 'Ingrese el efetivo...');
                    return;
                }
                if ($this->total > $this->efectivo) {
                    $this->emit('sale-error', 'el efetivo de venta debe de ser mayor o igual al total resultado');
                    return;
                }
                if ($this->tipoenvio == '0') {
                    $sale = Sale::create([
                        'total' => $this->total,
                        'items' => $this->itemsQuantity,
                        'dinero' => $this->efectivo,
                        'cambio' => $this->change,
                        'tipo_pago' => $this->tipopago,
                        'user_id' => Auth()->user()->id,
                        'client_id' => $this->client_id,

                    ]);
                } else {
                    $sale = Sale::create([
                        'total' => $this->total,
                        'items' => $this->itemsQuantity,
                        'dinero' => $this->efectivo,
                        'cambio' => $this->change,
                        'tipoVenta' => 'Envio',
                        'direccion' => $this->direccion,
                        'tipo_pago' => $this->tipopago,
                        'user_id' => Auth()->user()->id,
                        'client_id' => $this->client_id,

                    ]);
                }


                if ($sale) {
                    $items = Cart::getContent();
                    foreach ($items as $item) {
                        SaleDetails::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'product_id' => $item->id,
                            'sale_id' => $sale->id,
                        ]);

                        $product = Product::find($item->id);
                        //$product->stock =-$item->quantity;
                        $product->stock = $product->stock - $item->quantity;
                        $product->save();
                    }
                }

                if ($sale) {
                    $xd = Meripuntos::Where('client_id', '=', $this->client_id)->get();
                    $xd2 = (count($xd) == 0);
                    if ($xd2 == 'true') {
                        Meripuntos::create([
                            'client_id' => $this->client_id,
                            'meripuntos' => $this->puntos,
                        ]);
                    } else {
                        //$xd = Meripuntos::Where('client_id', '=', $this->client_id)->get();
                        $category = Meripuntos::Where('client_id', '=', $this->client_id)->first();
                        $p = $category->meripuntos + $this->puntos;
                        $category->update([
                            'meripuntos' => $p,
                        ]);
                    }
                }
            } elseif ($this->tipopago == 1) {
                if ($this->efectivo <= 0) {
                    $this->emit('sale-error', 'Ingrese el efetivo...');
                    return;
                }
                $category = Meripuntos::Where('client_id', '=', $this->client_id)->first();
                // if ($category->limite < Cart::getTotal()  && $category->saldo < $category->limite) {
                //     $this->emit('sale-error', 'el limite es de $category->limite ');
                //     return;
                // }
                if ($category->limite < Cart::getTotal()) {
                    $this->emit('sale-error', 'A superado el limite de credito');
                    return;
                }
                if ($category->limite < $category->saldo) {
                    $this->emit('sale-error', 'credito insuficiente');
                    return;
                }

                $sald = $category->saldo + (Cart::getTotal() - $this->efectivo);
                $ab = $category->abono + $this->efectivo;
                $category->update([
                    'saldo' => $sald,
                    'abono' => $ab,
                ]);
                $sale = Sale::create([
                    'total' => $this->total,
                    'items' => $this->itemsQuantity,
                    'dinero' => $this->efectivo,
                    'cambio' => 0,
                    'tipo_pago' => $this->tipopago,
                    'estado' => "Pediente",
                    'user_id' => Auth()->user()->id,
                    'client_id' => $this->client_id,

                ]);
                if ($sale) {
                    $items = Cart::getContent();
                    foreach ($items as $item) {
                        SaleDetails::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'product_id' => $item->id,
                            'sale_id' => $sale->id,
                        ]);

                        $product = Product::find($item->id);
                        //$product->stock =-$item->quantity;
                        $product->stock = $product->stock - $item->quantity;
                        $product->save();
                    }
                }
            } elseif ($this->tipopago == 2) {

                $sale = Sale::create([
                    'total' => $this->total = Cart::getTotal(),
                    'items' => $this->itemsQuantity,
                    'dinero' => $this->efectivo,
                    'cambio' => $this->change,
                    'tipo_pago' => $this->tipopago,
                    'user_id' => Auth()->user()->id,
                    'client_id' => $this->client_id,

                ]);

                $total =   $this->total = Cart::getTotal();
                $items = $this->itemsQuantity;

                $this->emit('print-ticket', $items, $total);

                if ($sale) {
                    $items = Cart::getContent();
                    foreach ($items as $item) {
                        SaleDetails::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'product_id' => $item->id,
                            'sale_id' => $sale->id,
                        ]);

                        $product = Product::find($item->id);
                        //$product->stock =-$item->quantity;
                        $product->stock = $product->stock - $item->quantity;
                        $product->save();
                    }
                }

                if ($sale) {
                    $xd = Meripuntos::Where('client_id', '=', $this->client_id)->get();
                    $xd2 = (count($xd) == 0);
                    if ($xd2 == 'true') {
                        Meripuntos::create([
                            'client_id' => $this->client_id,
                            'meripuntos' => $this->puntos,
                        ]);
                    } else {
                        //$xd = Meripuntos::Where('client_id', '=', $this->client_id)->get();
                        $category = Meripuntos::Where('client_id', '=', $this->client_id)->first();
                        $p = $category->meripuntos + $this->puntos;
                        $category->update([
                            'meripuntos' => $p,
                        ]);
                    }
                }
            }
            DB::commit();

            $total = $this->total;
            $items = $this->itemsQuantity;
            $idventa = Sale::select('id')->orderBy('id', 'desc')->first();

            $this->emit('print-ticket', $idventa->id, $items, $total);
            Cart::clear(); //limpiamos e inicializamos las varibles..
            $this->tipoenvio = 0;
            $this->efectivo = 0;
            $this->change = 0;
            $this->puntos = 0;
            //$this->client_id = 0;
            $this->client_id = 5;
            $this->tipopago = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Venta procesado con Exito.');
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('sale-error', $e->getMessage());
        }
    }



    public function printTicket($idventa, $total, $items)
    {
        $data = [];
        $data = Cart::getContent()->sortBy('name');
        /*$data = Sale::join('sale_details as d', 'd.sale_id' , 'sales.id')
        ->select('*',)
        ->where('sales.id', $idventa)
        ->get();*/
        $data = SaleDetails::join('products as p', 'p.id', 'sale_details.product_id')
            ->select('sale_details.id', 'p.name', 'sale_details.price', 'sale_details.quantity')
            ->where('sale_details.sale_id', $idventa)
            ->get();
        $infoE = Informacion::where('id', 1)->first();
        $user = Auth::user()->name;
        $fecha = Carbon::now();
        $pdf = PDF::loadView('pdf.uwu', compact('data', 'total', 'items', 'user', 'infoE'));
        return $pdf->stream('salesReport.pdf');
        return $pdf->download('salesReport.pdf');

        Cart::clear(); //limpiamos e inicializamos las varibles..
    }
    /// lo comente por si habia pedos jejeje
    // public function SyncPermiso($state, $id)
    // {
    //     $product = Product::find($id);
    //     $item = Cart::get($id);
    //     $cart = Cart::getContent()->sortBy('name');
    //     Cart::remove($id);

    //     if ($state == 'true') {
    //         Cart::add($product->id, $product->name, $product->price_mayoreo, $item->quantity, $product->image);
    //         $title = 'Mayoreo producto:';
    //     } else {

    //         Cart::add($product->id, $product->name, $product->price, $item->quantity, $product->image);
    //         $title = 'Menudeo producto:';
    //     }

    //     $this->estadoCheck = $state;
    //     $this->producId = $id;
    //     $this->total = Cart::getTotal();
    //     $this->puntos = (Cart::getTotal()) / 100 * 10;
    //     $this->itemsQuantity = Cart::getTotalQuantity();
    //     $this->emit('scan-ok', "$title $product->name");
    // }
    public function SyncPermiso($state, $id)
    {
        $product = Product::find($id);
        $item = Cart::get($id);
        $cart = Cart::getContent()->sortBy('name');
        Cart::remove($id);

        if ($state == 'true') {
            if ($this->tipo_precio == '1') {
                Cart::add($product->id, $product->name, $product->price_mayoreo, $item->quantity, $product->image);
                $title = 'Mayoreo producto:';
            } else {
                Cart::add($product->id, $product->name, $product->cost, $item->quantity, $product->image);
                $title = 'costo producto:';
            }
        } else {
            Cart::add($product->id, $product->name, $product->price, $item->quantity, $product->image);
            $title = 'Menudeo producto:';
        }


        $this->estadoCheck = $state;
        $this->producId = $id;
        $this->total = Cart::getTotal();
        $this->puntos = (Cart::getTotal()) / 100 * 10;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', "$title $product->name");
    }

    public function SyncAll()
    {

        $this->cheked = '1'; ///utilizare esta variable para manipularlo  con el input select
        $cart = Cart::getContent()->sortBy('name');
        foreach ($cart as $c) {
            $this->SyncPermiso('true', $c->id);
            $c->checado = 1;
        }
    }
    public function SyncDel()
    {
        $this->cheked = '0';
        $cart = Cart::getContent()->sortBy('name');
        foreach ($cart as $c) {
            $this->SyncPermiso('false', $c->id);
            $c->checado = 0;
        }
    }


    public function stockcolores($productId)
    {
        $da = Product::find($productId);
        $cart = Cart::get($productId);
        // $cart=Cart::getContent()->sortBy('name');


        $car = Cart::getContent()->sortBy('name');
        foreach ($car as $c) {
            // $da = Product::Where('name', $c->id)->get();
            if ($da->stock < $da->alerts) {
                $this->colorStock = $cart->id;
                $datis = [
                    'barcode' => $cart->barcode,
                    'id' => $cart->id
                ];
            } else {
                $this->colorStock = '0';
            }
        }
    }

    public function Consultar()
    {
        $this->cangeo = 1;
        $dataD = Meripuntos::Where('client_id', $this->client_id)->first();

        if (empty($dataD)) {
            $this->emit('sale-error', 'Para poder obtener puntos, Favor de comprar.');
            return;
        }
        if ($this->puntos < $this->puntos1) {
            $this->puntos = $this->puntos;
            return;
        }

        if ($dataD != null) {
            $this->puntos = 0.1 * $dataD->meripuntos;
            $this->check_meripoints();
            $this->puntos1 = $this->puntos;
        }
        if ($dataD->meripuntos < 1) {
            $this->emit('sale-error', 'No cuenta con Meripuntos, Siga Participando.');
            return;
        }
    }

    public function check_meripoints()
    {
        #consulta los productos conforme a los puntos xd
        $this->datosxd = Product::Where('price', '<=', $this->puntos)->get();
    }

    public function Meri($barcode, $cant = 1)
    {

        $product = Product::where('barcode', $barcode)->first();

        if ($product == null) {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        } else {

            if ($product->price > $this->puntos) {

                $this->emit('no-stock', 'Ya no cuentas con los puntos suficientes :!');
                return;
            }
            if ($this->InCart($product->id)) {


                $this->incre_meri($product->id);
                return;
            }

            if ($product->stock < 1) {

                $this->emit('no-stock', 'Stock insuficiente :/');
                return;
            }
            if ($product->price < $this->puntos) {
                Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            }

            $this->total = Cart::getTotal();
            $this->p =  $this->puntos1 - $this->total;
            $this->puntos = $this->p;
            $this->tipopago = 3;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Producto agregado.');
        }
    }
    public function saveMeri()
    {
        //transaccion a la bd para guardar la venta en detalles venta
        DB::beginTransaction();
        try {
            $mer = Meripuntos::Where('client_id', '=', $this->client_id)->first();
            $p =  $this->puntos * 10;
            $mer->update([
                'meripuntos' => $p,
            ]);

            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'dinero' => $this->efectivo,
                'cambio' => 0,
                'tipo_pago' => $this->tipopago,
                'user_id' => Auth()->user()->id,
                'client_id' => $this->client_id,
                'estado' => "Meripuntos",

            ]);
            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetails::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    $product = Product::find($item->id);
                    //$product->stock =-$item->quantity;
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();
            Cart::clear(); //limpiamos e inicializamos las varibles..
            $this->efectivo = 0;
            $this->change = 0;
            $this->puntos = 0;
            $this->puntos1 = '';
            $this->client_id = 5;
            $this->cangeo = 0;
            $this->tipopago = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Se Procesado el Canjeo con ??Exito!.');
            //  $this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function decreaseMeri($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);
        $newQty = ($item->quantity) - 1;

        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

        $this->total = Cart::getTotal();
        $this->p =  $this->puntos1 - $this->total;
        $this->puntos = $this->p;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Cantidad actualizada');
    }

    public function updateMery($productId, $cant)
    {
        $title = '';
        //$meriP = Meripuntos::find($id);
        $meriP = Meripuntos::where('client_id', '=', $this->client_id)->first();
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        $merivalor = ($product->price * 10) * $cant;
        if ($merivalor <= $meriP->meripuntos) {
            if ($exist)
                $title = 'Cantidad actualizada';
            else
                $title = 'Producto agregado';
        } else {
            $this->emit('no-stock', 'Meripuntos insuficiente');
            return;
        }


        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }



        if ($cant > 0) {


            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            $this->total = Cart::getTotal();
            $this->p =  $this->puntos1 - $this->total;
            $this->puntos = $this->p;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }

    public function remover($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->p =  $this->puntos1 - $this->total;
        $this->puntos = $this->p;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Producto eliminado');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->datosxd = [];
        $this->datauwuxd = [];
        $this->barcode = '';
        $this->search = '';
        $this->searchD = '';
        $this->puntos1 = '';
    }
}
