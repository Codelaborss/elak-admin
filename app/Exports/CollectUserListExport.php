<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CollectUserListExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings, WithEvents
{
    use Exportable;
    protected $users;

    public function __construct($users) {
        $this->users = $users;
    }

    public function view(): View
    {
        return view('file-exports.collect-user-list', [
            'users' => $this->users,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // SL
            'B' => 20,  // Name
            'C' => 15,  // Username
            'D' => 15,  // Phone
            'E' => 25,  // Email
            'F' => 15,  // Ref ID (Created At)
            'G' => 18,  // Status
            'H' => 18,  // Created At
            'I' => 15,  // Updated At (Ref By)
        ];
    }

    public function styles(Worksheet $sheet) {
        // Style the header rows
        $sheet->getStyle('A2:I3')->getFont()->setBold(true);
        $sheet->getStyle('A3:I3')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => '9F9F9F'],
        ]);

        $sheet->setShowGridlines(false);

        // Apply borders to all data cells
        $lastRow = $this->users->count() + 3;
        return [
            'A1:I' . $lastRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $this->users->count() + 3;

                // Center align title
                $event->sheet->getStyle('A1:I1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Center align merged cell in row 2
                $event->sheet->getStyle('A2:C2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Center align headers and data
                $event->sheet->getStyle('A3:I' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Left align the right side of row 2
                $event->sheet->getStyle('D2:I2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Merge cells for title and info
                $event->sheet->mergeCells('A1:I1');
                // $event->sheet->mergeCells('A2:C2');
                // $event->sheet->mergeCells('D2:I2');

                // Set row heights
                // $event->sheet->getRowDimension(2)->setRowHeight(100);
                // $event->sheet->getDefaultRowDimension()->setRowHeight(30);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'SL', 'Name', 'Username', 'Phone', 'Email', 'Ref ID', 'Status', 'Created At', 'Updated At'
        ];
    }
}
