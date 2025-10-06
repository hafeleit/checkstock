<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RTTExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell
{
    private $mappedData;

    public function __construct(array $mappedData)
    {
        $this->mappedData = $mappedData;
    }

    public function collection()
    {
        return new Collection($this->mappedData);
    }

    public function headings(): array
    {
        return [
            'ERP Document',
            'Job Number',
            'Shipment number',
            'Weight',
            'Volume',
            'Number of Handling Units',
            'Address',
            'Sub District + District(City)',
            'ORION Province (ENG)',
            'Postal Code',
        ];
    }
    public function map($row): array
    {
        return [
            $row['erp_document'],
            $row['job_number'],
            $row['shipment_number'],
            $row['weight'],
            $row['volume'],
            $row['handling_units'],
            $row['address'],
            $row['city'],
            $row['province'],
            $row['postal_code'],
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        // จัดรูปแบบหัวตาราง
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // *** เพิ่มเส้นขอบให้กับหัวตาราง (A1:J1) ***
        $sheet->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // *** เพิ่มเส้นขอบให้กับข้อมูลในตาราง ***
        $lastRow = count($this->mappedData) + 1;
        $range = 'A1:J' . $lastRow;

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // จัดความกว้างคอลัมน์
        foreach (range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
