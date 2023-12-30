<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromView, WithColumnWidths, WithColumnFormatting, WithStyles
{
    public function view(): View
    {
        return view('excel_exports.user_excel', [
            'users' => User::all(),
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 100,
            'C' => 100,
            'D' => 100,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '@', // Treat column C as a string
            'D' => 'yyyy-mm-dd h:mm:ss', // Treat column D as a date
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '7D7D7D',
                ],
            ],
        ]);
    }
}
