<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use App\Models\SaleDetails;
use App\Models\Meripuntos;
use Illuminate\Support\Facades\Auth;


class CashoutController extends Component
{
    public $fromDate, $x, $m, $tipo_v, $ef, $toDate, $userid, $total, $trj, $items, $sales, $details, $abonos, $nt;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = Auth::user()->id;
        $this->total = 0;
        $this->tipo_v = 0;
        $this->m = 0;
        $this->trj = 0;
        $this->abonos = 0;
        $this->ef = 0;
        $this->x = 1;
        $this->items = 0;
        $this->nt = 0;
        $this->sales = [];
        $this->details = [];
    }
    public function render()
    {
        //  $this->defe();
        return view('livewire.cashout.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')->section('content');
    }

    public function defecto()
    {
        $this->fromDate = Carbon::now()->format('y-m-d') . ' 00:00:00';
        $this->toDate = Carbon::now()->format('y-m-d') . ' 00:00:00';
    }
    public function Consultar()
    {
        //  $this->x = 1;
        //en esta parte definimos el formato de la fecha y la hora para posteriomente utilizarlo en la consulta.
        $fi = Carbon::parse($this->fromDate)->format('y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('y-m-d') . ' 23:59:59';
        //returna la vista
        if ($this->tipo_v == 0) {
            # code...
            $this->sales = Sale::WhereBetween('created_at', [$fi, $ff])
                //  ->where('estado', 'Pagado')
                ->where('user_id', $this->userid)->get();
            // $this->total = $this->sales ? $this->sales->sum('total') : 0;
            $this->items = $this->sales ? $this->sales->sum('items') : 0;
            //  $this->ef = $this->sales ? $this->sales->sum('items') : 0;

            $l = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Pagado')->get();
            $this->total = $l ? $l->sum('total') : 0;

            //ventas en efectivo
            $efec = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('tipo_pago', '0')->get();
            $this->ef = $efec ? $efec->sum('total') : 0;
            //venta con tarjeta de debito
            $tar = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('tipo_pago', '2')->get();
            $this->trj = $tar ? $tar->sum('total') : 0;
            // ventas meripuntos
            $p = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Meripuntos')->get();
            $this->m = $p ? $p->sum('total') : 0;
            // abonos
            $clien = Meripuntos::WhereBetween('updated_at', [$fi, $ff])->get();
            $this->abonos = $clien ? $clien->sum('abono') : 0;
            //total de vetas netos

        } elseif ($this->tipo_v == 1) {
            $this->sales = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Pagado')
                ->where('user_id', $this->userid)->get();
            // $this->total = $this->sales ? $this->sales->sum('total') : 0;
            $this->items = $this->sales ? $this->sales->sum('items') : 0;
            //  $this->ef = $this->sales ? $this->sales->sum('items') : 0;

            $l = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Pagado')->get();
            $this->total = $l ? $l->sum('total') : 0;

            //ventas en efectivo
            $efec = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('tipo_pago', '0')->get();
            $this->ef = $efec ? $efec->sum('total') : 0;
            //venta con tarjeta de debito
            $tar = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('tipo_pago', '2')->get();
            $this->trj = $tar ? $tar->sum('total') : 0;
            $this->m = 0;
            $this->abonos = 0;
        } elseif ($this->tipo_v == 2) {
            $this->sales = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Pediente')
                ->where('user_id', $this->userid)->get();
            // $this->total = $this->sales ? $this->sales->sum('total') : 0;
            $this->items = $this->sales ? $this->sales->sum('items') : 0;
            $this->total = $this->sales ? $this->sales->sum('total') : 0;
            $this->ef = 0;
            //venta con tarjeta de debito
            $this->trj = 0;
            $this->m = 0;
            $this->abonos = 0;
        } elseif ($this->tipo_v == 3) {
            $this->sales = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Meripuntos')
                ->where('user_id', $this->userid)->get();
            // $this->total = $this->sales ? $this->sales->sum('total') : 0;
            $this->items = $this->sales ? $this->sales->sum('items') : 0;
            $this->total = 0;
            $this->ef = 0;
            //venta con tarjeta de debito
            $this->trj = 0;
            $p = Sale::WhereBetween('created_at', [$fi, $ff])
                ->where('estado', 'Meripuntos')->get();
            $this->m = $p ? $p->sum('total') : 0;
            $this->abonos = 0;
        }

        $this->nt = $this->m + $this->abonos + $this->total;
    }
    public function venta_dia()
    {
        $this->x = 0;
        //en esta parte definimos el formato de la fecha y la hora para posteriomente utilizarlo en la consulta.
        $this->fromDate = Carbon::now();
        $this->toDate = Carbon::now();
        $fi = Carbon::parse($this->fromDate)->format('y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('y-m-d') . ' 23:59:59';

        $this->sales = Sale::WhereBetween('created_at', [$fi, $ff])
            ->where('estado', 'Pagado')
            ->where('user_id', $this->userid)->get();
        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;
        //$this->x = 1;
    }

    public function viewDeatails(Sale $sale)
    {
        # code...
        $fi = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->details = Sale::join('sale_details as d', 'd.sale_id', 'sales.id')
            ->join('products as p', 'p.id', 'd.product_id')
            ->select('d.sale_id', 'p.name as product', 'd.quantity', 'd.price')
            ->WhereBetween('sales.created_at', [$fi, $ff])
            // ->where('sales.estado', 'Pagado')
            ->Where('sales.user_id', $this->userid)
            ->where('sales.id', $sale->id)->get();

        $this->emit('show-modal', 'Detalles de venta');
    }

    public function Print()
    {
        # code...
    }
}
