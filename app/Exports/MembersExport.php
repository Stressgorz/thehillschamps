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

class MembersExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $refs = [];

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function headings(): array
    {
        return [
            'Status',
            'Ib Code',
            'Name',
            'Phone',
            'Position',
            'Team',
            'Points',
            'DOB',
            'Gender',
            'Email',
            'Created Date',
            'Upline',
        ];
    }
    
    public function map($member): array
    {

        return [
            Helper::$general_status[$member->status],
            $member->ib_code,
            $member->firstname.' '.$member->lastname,
            $member->phone,
            $member->position_name,
            $member->team_name,
            $member->user_points ?? 0,
            $member->dob,
            $member->gender,
            $member->email,
            $member->created_at,
            $member->upline_firstname . $member->upline_lastname,
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
        return $this->members;
    }
}
