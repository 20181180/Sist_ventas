<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Sale;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; //para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithTitle; //sirve para definir el nombre del libro
use Maatwebsite\Excel\Concerns\WithStyles; //sirve para dar estilo a la hoja de excel
use Maatwebsite\Excel\Concerns\WithCustomStartCell; //define la celda donde incia el reporte
use Maatwebsite\Excel\Concerns\WithHeadings; //sirve para definir el ecabezado de las paginas de libro
use Maatwebsite\Excel\Concerns\FromCollection; //sorve para trabajar con colecciones y asi obetner la data

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{
    protected $userId, $dateFrom, $dateTo, $reportType;

    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
    }

    public function collection()
    {
        $data = [];
        if ($this->reportType == 1) {

            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to =  Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
            /*
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to =  Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';*/
        } else {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to =  Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }

        /*if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }*/
        if ($this->userId == 0) {

            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.id', 'sales.total', 'sales.items', 'sales.estado', 'sales.created_at', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.id', 'sales.total', 'sales.items', 'sales.estado', 'sales.created_at', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $this->userId)
                ->get();
        }
        return $data;
    }

    //Ecabezados para el archivo excel
    public function headings(): array
    {
        return ["Folio", "Importe", "Items", "Status", "Fecha", "Usuario"];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Reporte de ventas de MejiroMechatronics';
    }
}
