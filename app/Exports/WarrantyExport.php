<?php

namespace App\Exports;

use App\Models\Warranty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WarrantyExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Warranty::query();

        if (!empty($this->filters['name'])) {
            $query->where('name', 'like', '%' . trim($this->filters['name']) . '%');
        }
        if (!empty($this->filters['tel'])) {
            $query->where('tel', trim($this->filters['tel']));
        }
        if (!empty($this->filters['serial_no'])) {
            $query->where('serial_no', trim($this->filters['serial_no']));
        }
        if (!empty($this->filters['order_number'])) {
            $query->where('order_number', trim($this->filters['order_number']));
        }

        return $query->latest()->get([
            'name', 'tel', 'email', 'article_no', 'serial_no',
            'order_channel', 'other_channel', 'order_number', 'addr',
            'is_consent_policy', 'is_consent_marketing', 'created_at',
        ]);
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->tel,
            $row->email,
            $row->article_no,
            $row->serial_no,
            $row->order_channel,
            $row->other_channel,
            $row->order_number,
            $row->addr,
            $row->is_consent_policy,
            $row->is_consent_marketing,
            $row->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'Name', 'Phone Number', 'Email', 'Article No.', 'Serial No.',
            'Order Channel', 'Other Channel', 'Order Number', 'Address',
            'Consent Policy', 'Consent Marketing', 'Registration Date',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
