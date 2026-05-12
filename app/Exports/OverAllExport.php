<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OverAllExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithCustomStartCell
{
    protected $invTrackings;
    private $rowIndex = 0;

    public function __construct($invTrackings)
    {
        $this->invTrackings = $invTrackings;
    }

    public function query()
    {
        return $this->invTrackings;
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
        $this->rowIndex++;

        return [
            $this->rowIndex,
            $row->logi_track_id,
            $row->driver_or_sent_to,
            $row->erp_document,
            $row->invoice_id,
            $row->delivery_date ? Carbon::parse($row->delivery_date)->format('d/m/Y H:i:s') : '',
            $row->created_date ? Carbon::parse($row->created_date)->format('d/m/Y H:i:s') : '',
            $row->created_by,
            $row->updated_by,
            $row->type,
            $row->remark ?? '',
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

        // หาตำแหน่งแถวสุดท้ายที่มีข้อมูล
        $lastRow = $sheet->getHighestRow();
        $range = 'A1:K' . $lastRow;

        // ใส่เส้นขอบทีเดียวทั้งตาราง
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // จัดความกว้างคอลัมน์
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
