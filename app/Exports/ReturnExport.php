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

class ReturnExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell
{
    private $mappedData;
    private $headerData;

    public function __construct(array $mappedData, array $headerData)
    {
        $this->mappedData = $mappedData;
        $this->headerData = $headerData;
    }

    public function collection()
    {
        return new Collection($this->mappedData);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Document No.',
            'Date',
            'Billing No.',
            'Remark'
        ];
    }

    public function map($row): array
    {
        return [
            $row['no'],
            $row['erp_document'],
            $row['created_date'],
            $row['invoice_id'],
            $row['remark'],
        ];
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'Return Document Sheet');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('A2', 'Doc No. : ' . $this->headerData['job_no']);
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('A3', 'Exported On: ' . $this->headerData['exported_on']);
        $sheet->mergeCells('A3:E3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('A4', 'Sent to: ' . $this->headerData['driver_id']);
        $sheet->mergeCells('A4:E4');
        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('A5', 'Created By: ' . $this->headerData['created_by']);
        $sheet->mergeCells('A5:E5');
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // จัดรูปแบบหัวตาราง
        $sheet->getStyle('A7:E7')->getFont()->setBold(true);
        $sheet->getStyle('A7:E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBDBDB');
        $sheet->getStyle('A7:E7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // *** เพิ่มเส้นขอบให้กับหัวตาราง (A7:E7) ***
        $sheet->getStyle('A7:E7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // *** เพิ่มเส้นขอบให้กับข้อมูลในตาราง ***
        $lastRow = count($this->mappedData) + 7;
        $range = 'A7:E' . $lastRow;

        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // จัดความกว้างคอลัมน์
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
