<?php
namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;

class UploadTLTemplateExport implements FromView, WithEvents
{
    use RegistersEventListeners;

    public function view(): View
    {
        return view('exports.upload_tl_template');
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        $cells = array('A3');
        foreach ($cells as $cell ) {
            $sheet->getStyle($cell)->getFont()
            ->setBold(true)
            ->getColor()->setRGB('ff0000');


        }
    }
}
