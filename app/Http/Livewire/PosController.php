<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Models\SaleDetails;
use App\Models\Meripuntos;
use App\Models\Denomination;
use App\Models\Cliente;
use App\Models\Cotizaciones;
use Darryldecode\Cart\Facades\CartFacade as Cart;
//use Dompdf\JavascriptEmbedder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
//anadi una prueva

class PosController extends Component
{
    public $colorStock, $puntos1, $category, $datosxd, $datauwuxd, $cheked, $searchD, $search, $estadoCheck, $producId, $tipoVenta, $client_id, $total, $itemsQuantity, $efectivo, $change, $valiente, $meri, $puntos;

    public function mount()
    {
        $this->colorStock = '';
        $this->tipoVenta = 'Elegir';
        $this->category = [];
        $this->datosxd = [];
        $this->datauwuxd = [];
        $this->client_id = 0;
        $this->estadoCheck = 'false';
        $this->cheked = '0';
        $this->efectivo = 0;
        $this->change = 0;
        $this->puntos1 = 0;
        $this->total = Cart::getTotal();
        $this->puntos = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {
        $cart = Cart::getContent()->sortBy('name');
        if (strlen($this->search) > 0)
            $data = Product::Where('name', 'like', '%' . $this->search . '%')->get();

        else
            $data = Product::orderBy('name', 'desc')->get();
        $dataD = [];
        foreach ($cart as $c) {
        }

        foreach ($cart as $c) {

            $product = Product::find($c->id);
            if ($c->quantity >= $product->stock) {
                $c->marcado = 1;
            }
            if ($c->price == $product->price_mayoreo) {
                $c->checado = 1;
            }
        }

        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'products' => $data,
            'cotiza' => $dataD,
            'clientes' => Cliente::orderBy('name', 'desc')->get(),
            'cart' => $cart,
            'tipoventa' => $this->tipoVenta,

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    //el metodo a cash es para calcular el cambio
    public function ACash($value)
    {
        //dd($value);
        /*$this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total) - 0.5;
        $this->efectivo = $this->efectivo - 0.5;*/

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
                $this->emit('scan-notfound', 'Su cotizacion a experido');
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
        $this->change = ($this->efectivo - $this->total);
    }
    //este evento es pra escanear el codigo de barras
    public function ScanCode($barcode, $cant = 1)
    {

        $product = Product::where('barcode', $barcode)->orWhere('name', $barcode)->first();

        if ($product == null) {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        } else {
            if ($this->InCart($product->id)) {

                $this->increaseQty($product->id, $this->estadoCheck);
                return;
            }
            if ($product->stock < 1) {

                $this->emit('no-stock', 'Stock insuficiente :/');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
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

                $this->emit('no-stock', 'Stock insuficiente1');
                return;
            }
        }
        if ($state == 'true') {
            Cart::add($product->id, $product->name, $product->price_mayoreo, $cant, $product->image);
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

                $this->emit('no-stock', 'Stock insuficiente1');
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
                Cart::add($product->id, $product->name, $product->price_mayoreo, $cant, $product->image);
            } else {

                Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            }
            $this->total = Cart::getTotal();
            $this->puntos = (Cart::getTotal()) / 100 * 10;
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
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
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->puntos = Cart::getTotal();
        $this->client_id = 0;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vaciado...');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos...');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->emit('sale-error', 'Ingrese el efetivo...');
            return;
        }
        if ($this->total > $this->efectivo) {
            $this->emit('sale-error', 'el efetivo de venta debe de ser mayor o igual al toal resultado');
            return;
        }
        //transaccion a la bd para guardar la venta en detalles venta
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'dinero' => $this->efectivo,
                'cambio' => $this->change,
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
            if ($sale) {

                //$uwu = Meripuntos::find($this->client_id);

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

            DB::commit();
            Cart::clear(); //limpiamos e inicializamos las varibles..
            $this->efectivo = 0;
            $this->change = 0;
            $this->puntos = 0;
            $this->client_id = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Venta procesado con Exito.');
            $this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
            DB::rollBack();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::to("print:://$sale->id");
    }

    public function SyncPermiso($state, $id)
    {
        $product = Product::find($id);
        $item = Cart::get($id);
        $cart = Cart::getContent()->sortBy('name');
        Cart::remove($id);

        if ($state == 'true') {
            Cart::add($product->id, $product->name, $product->price_mayoreo, $item->quantity, $product->image);
            $title = 'Mayoreo producto:';
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

        $this->cheked = '1';
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
        $dataD = Meripuntos::Where('client_id', $this->client_id)->first();

        if ($dataD != null) {
            $this->datosxd = Product::Where('price', '<=', $dataD->meripuntos)->get();
            $this->puntos = $dataD->meripuntos;
            $this->puntos1 = $dataD->meripuntos;
        }
        if ($dataD->meripuntos < 1) {
            $this->emit('sale-error', 'No cuenta con Meripuntos, Siga Participando jaja xd.');
            return;
        }
    }

    public function Meri($barcode, $cant = 1)
    {

        $product = Product::where('barcode', $barcode)->first();

        if ($product == null) {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        } else {

            if ($product->price > $this->puntos) {

                $this->emit('no-stock', 'Ya valio, Ya no cuentas con los puntos suficientes :-/');
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
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', 'Producto agregado');
        }
    }
    public function saveMeri()
    {
        //transaccion a la bd para guardar la venta en detalles venta
        DB::beginTransaction();
        try {
            $mer = Meripuntos::Where('client_id', '=', $this->client_id)->first();
            $p =  $this->puntos;
            $mer->update([
                'meripuntos' => $p,
            ]);
            DB::commit();
            Cart::clear(); //limpiamos e inicializamos las varibles..
            $this->efectivo = 0;
            $this->change = 0;
            $this->puntos = 0;
            $this->client_id = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Canjeos procesado con ¡Exito!.');
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

    public function resetUI()
    {
        $this->name = '';
        $this->datosxd = [];
        $this->datauwuxd = [];
        // $this->client_id = 0;
        $this->barcode = '';
        $this->search = '';
        $this->searchD = '';
    }
}
