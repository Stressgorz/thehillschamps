<?php

namespace App\Exports;

use App\System;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Helper;

class SaleExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $refs = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Status',
            'Broker',
            'Amounts',
            'Client Name',
            'Phone',
            'Client Email',
            'MT4 ID',
            'IB',
            'Sales Date',
            'Submission Date',
        ];
    }
    
    public function map($data): array
    {

        return [
            Helper::$approval_status[$data->sales_status],
            $data->broker_type,
            $data->amount,
            $data->client_name,
            $data->client_contact,
            $data->client_email,
            $data->mt4_id,
            $data->user_firstname .' '.$data->user_lastname,
            $data->date,
            $data->updated_at,
        ];
    }
    
    public function columnFormats(): array
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $last_row = $event->sheet->getHighestDataRow();
            },
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
}
