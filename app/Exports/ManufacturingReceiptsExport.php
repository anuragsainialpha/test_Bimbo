<?php

namespace App\Exports;

use App\Models\Receipt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ManufacturingReceiptsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Receipt::Select('id', 'item_code', 'facility_code', 'wms_asn_nbr', 'std_pallet_qty', 'batch_nbr', 'shipped_qty', 'received_qty', 'status')->Get();
    }
	
	public function headings(): array
    {
        return [
            'ID',
            'Item Code',
			'Facility Code	',
			'WMS ASN Number',	
			'Standard Pallet Quantity',
			'Batch Number',
			'Shipped Quantity',	
			'Received Quantity',	
			'Status',
        ];
    }
	
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
