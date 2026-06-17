<?php

namespace App\Exports;

use App\Models\Lawsuit;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClaimsExport implements FromCollection, WithHeadings
{
    protected $fromDate;
    protected $toDate;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    public function collection()
    {
        return Lawsuit::with(
            'client',
            'car',
            'agent',
            'appraiser_data',
            'inc_company',
            'comments',
            'documents'
        )->whereBetween('payment_date', [$this->fromDate, $this->toDate])->get()->map(function ($claim) {
            return [
                'Claim No.' => $claim->lawsuit_no,
                'Check Date' => $claim->payment_date,
                'Client' => $claim->client ? $claim->client->name : null,
                'TZ' => $claim->client ? $claim->client->tz : null,
                'License No.' => $claim->car ? $claim->car->license_plate : null,
                'Email' => $claim->client ? $claim->client->email : null,
                'Phone' => $claim->client ? $claim->client->phone : null,
                'Vehicle No.' => $claim->car ? $claim->car->license_plate : null,
                'Manufacturer' => $claim->car ? $claim->car->manufacturer : null,
                'Year' => $claim->car ? $claim->car->year : null,
                'Date Of Accident' => $claim->lawsuit_begin_date,
                'Third Party Vehicle No.' => $claim->third_party_plate,
                'Insurance Company' => $claim->inc_company ? $claim->inc_company->name : null,
                'Handling Agent' => $claim->agent ? $claim->agent->name : null,
                'Appraiser' => $claim->appraiser_data ? $claim->appraiser_data->name : null,
                'Check Total' => $claim->check_total,
                'Deductible' => $claim->deductible,
                'VAT' => $claim->vat,
                'Status' => __($claim->status_text),
                'Invoice No.' => $claim->invoice_no, 
            ];
        });
    }

    public function headings(): array
    {

        return [
        Lang::get('Claim No.'),
        Lang::get('Check Date'),
        Lang::get('Client'),
        Lang::get('TZ'),
        Lang::get('License No.'),
        Lang::get('Email'),
        Lang::get('Phone'),
        Lang::get('Vehicle No.'),
        Lang::get('Manufacturer'),
        Lang::get('Year'),
        Lang::get('Date Of Accident'),
        Lang::get('Third Party Vehicle No.'),
        Lang::get('Insurance Company'),
        Lang::get('Handling Agent'),
        Lang::get('Appraiser'),
        Lang::get('Check Total'),
        Lang::get('Deductible'),
        Lang::get('VAT'),
        Lang::get('Status'),
        Lang::get('Invoice No.'), 
    ];

    }
}
