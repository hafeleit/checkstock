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

class ExportOrdersSAP extends DefaultValueBinder implements FromArray, WithColumnFormatting, WithColumnWidths, WithTitle, WithCustomValueBinder
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
        if ($cell->getColumn() == 'E') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        if ($cell->getColumn() == 'AC') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        if ($cell->getColumn() == 'AG') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        if ($cell->getColumn() == 'AH') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }
        if ($cell->getColumn() == 'AL') {
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
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
            'AC' => NumberFormat::FORMAT_TEXT,
            'AG' => NumberFormat::FORMAT_TEXT,
            'AH' => NumberFormat::FORMAT_TEXT,
            'AL' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function array(): array
    {
        return $this->data;
    }
}
