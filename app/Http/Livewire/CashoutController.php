<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetails;
use Carbon\Carbon;


class CashoutController extends Component
{
    public $fromDate, $toDate, $userid, $total, $items, $sales, $details;

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total = 0;
        //$this->items = [];
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
        //en esta parte definimos el formato de la fecha y la hora para posteriomente utilizarlo en la consulta.
        $fi = Carbon::parse($this->fromDate)->format('y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->toDate)->format('y-m-d') . ' 23:59:59';

        $this->sales = Sale::WhereBetween('created_at', [$fi, $ff])
            ->where('estado', 'Pagado')
            ->where('user_id', $this->userid)->get();
        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;
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
            ->where('sales.estado', 'Pagado')
            ->Where('sales.user_id', $this->userid)
            ->where('sales.id', $sale->id)->get();

        $this->emit('show-modal', 'Detalles de venta');
    }

    public function Print()
    {
        # code...
    }
}
