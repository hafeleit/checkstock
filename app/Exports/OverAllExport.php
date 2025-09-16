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

class OverAllExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell
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
            'No.',
            'LogiTrack ID',
            'Driver/Sent To',
            'ERP Document No.',
            'Billing No.',
            'Delivery Date',
            'Created Date',
            'Created By',
            'Updated By',
            'Type',
            'Remark'
        ];
    }
    public function map($row): array
    {
        return [
            $row['no'],
            $row['logi_track_id'],
            $row['driver_or_sent_to'],
            $row['erp_document'],
            $row['invoice_id'],
            $row['delivery_date'],
            $row['created_date'],
            $row['created_by'],
            $row['updated_by'],
            $row['type'],
            $row['remark'],
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        // จัดรูปแบบหัวตาราง
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // *** เพิ่มเส้นขอบให้กับหัวตาราง (A1:K1) ***
        $sheet->getStyle('A1:K1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // *** เพิ่มเส้นขอบให้กับข้อมูลในตาราง ***
        $lastRow = count($this->mappedData) + 1;
        $range = 'A1:K' . $lastRow;

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // จัดความกว้างคอลัมน์
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
