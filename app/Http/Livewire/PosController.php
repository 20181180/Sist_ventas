<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Models\SaleDetails;
use App\Models\Denomination;
use App\Models\Cliente;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//anadi una prueva

class PosController extends Component
{
    public $cheked,$estadoCheck,$producId,$tipoVenta, $client_id, $total, $itemsQuantity, $efectivo, $change, $valiente, $meri, $puntos;

    public function mount()
    {
        $this->tipoVenta = 'Elegir';
        $this->client_id = 'Elegir';
        $this->estadoCheck='false';
        $this->cheked='0';
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->puntos = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    public function render()
    {
        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'clientes' => Cliente::orderBy('name', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
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
    ];

    public function ACashAmano($value)
    {
        $this->efectivo = ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }
    //este evento es pra escanear el codigo de barras
    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product == null) {
            $this->emit('scan-notfound', 'El producto no esta registrado');
        } else {
            if ($this->InCart($product->id)) {

                $this->increaseQty($product->id,$this->estadoCheck);
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
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }
        if($state=='true'){
            Cart::add($product->id, $product->name, $product->price_mayoreo, $cant , $product->image);

        }else{

            Cart::add($product->id, $product->name, $product->price, $cant , $product->image);

        }
        $this->total = Cart::getTotal();
        $this->puntos = (Cart::getTotal()) / 100 * 10;
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);
    }

    //reemplaza el registro del carrito
    public function updateQty($productId,$state,$cant = 1)
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
            if($state=='true'){
                Cart::add($product->id, $product->name, $product->price_mayoreo, $cant , $product->image);

            }else{

                Cart::add($product->id, $product->name, $product->price, $cant , $product->image);

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
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', 'Carrito vaciado...');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega prodctos...');
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
        $cart=Cart::getContent()->sortBy('name');
        Cart::remove($id);

        if($state=='true'){
            Cart::add($product->id, $product->name, $product->price_mayoreo, $item->quantity , $product->image);
            $title='Mayoreo producto:';

        }else{

            Cart::add($product->id, $product->name, $product->price, $item->quantity , $product->image);
            $title='Menudeo producto:';
        }

        $this->estadoCheck=$state;
        $this->producId=$id;
        $this->total = Cart::getTotal();
        $this->puntos = (Cart::getTotal()) / 100 * 10;
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', "$title $product->name" );
    }
    public function SyncAll(){

        $this->cheked= 1;
        $cart=Cart::getContent()->sortBy('name');
        foreach($cart as $c){
            $this->SyncPermiso('true',$c->id);
        }

    }
    public function SyncDel(){
        $this->cheked= 0;
        $cart=Cart::getContent()->sortBy('name');
        foreach($cart as $c){
            $this->SyncPermiso('false',$c->id);
        }

    }
}
