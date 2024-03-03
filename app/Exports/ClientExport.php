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

class ClientExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithEvents
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
            'Name',
            'IB',
            'Upline (IB)',
            'Upline (Client)',
            'Email',
            'Contact',
            'State',
            'Country',
            'Team Of IB',
            'Created At',
        ];
    }
    
    public function map($data): array
    {

        return [
            $data->name,
            $data->user_firstname .' '.$data->user_lastname,
            $data->upline_user_firstname .' '.$data->upline_user_lastname,
            $data->upline_client_name,
            $data->email,
            $data->contact,
            $data->state,
            $data->country,
            $data->team_name,
            $data->created_at,
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
