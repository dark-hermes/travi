<?php

namespace App\Exports;

use App\Models\Reservation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReservationsExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    protected $reservations;

    public function __construct($reservations)
    {
        $this->reservations = $reservations;
    }

    public function headings(): array
    {
        return [
            [
                'DATE',
                'CUSTOMER NAME',
                'TOUR PACKAGE',
                'STATUS',
                'PRICE',
                'QTY',
                'SUBTOTAL',
                'DISCOUNT',
                'TOTAL',
                'PAID AT',
            ]
        ];
    }

    public function map($reservations): array
    {
        $date = Carbon::parse($reservations->date);
        $paidAt = Carbon::parse($reservations->paid_at);

        return [
            $date->format('d M Y'),
            $reservations->customer->user->name,
            $reservations->tourPackage->name,
            $reservations->status,
            $reservations->price,
            $reservations->quantity,
            $reservations->subtotal_price,
            $reservations->discount,
            $reservations->total_price,
            $paidAt->format('d M Y'),
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->reservations;
    }
}
