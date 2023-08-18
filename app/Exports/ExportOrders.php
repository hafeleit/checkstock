<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ExportOrders extends DefaultValueBinder implements FromArray, WithColumnFormatting, WithColumnWidths, WithTitle, WithCustomValueBinder
{
    protected $invoices;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Sheet1';
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'F') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function columnWidths(): array
    {
        return [
            'B' => 13,
            'F' => 22,
            'I' => 12,
            'X' => 15,
            'Y' => 11,
            'AG' => 15,
            'AN' => 15,
            'AO' => 15,
        ];
    }

    public function columnFormats(): array
    {
        return [
            //'F' => NumberFormat::FORMAT_TEXT,
            'Y' => NumberFormat::FORMAT_TEXT,
            'AO' => NumberFormat::FORMAT_NUMBER,
            'AN' => NumberFormat::FORMAT_NUMBER,
            'AG' => NumberFormat::FORMAT_NUMBER,
            'AE' => NumberFormat::FORMAT_TEXT,
            'AM' => NumberFormat::FORMAT_TEXT,

            /*'F' => NumberFormat::FORMAT_NUMBER,
            'Y' => NumberFormat::FORMAT_TEXT,
            'AG' => NumberFormat::FORMAT_NUMBER,
            'AN' => NumberFormat::FORMAT_NUMBER,
            'AO' => NumberFormat::FORMAT_NUMBER,
            'AE' => NumberFormat::FORMAT_TEXT,*/
            //'AM' => NumberFormat::FORMAT_NUMBER_00,
            //'AG' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function array(): array
    {
        return $this->data;
    }
}
