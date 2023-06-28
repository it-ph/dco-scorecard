<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class TlScorecardSummaryExport implements FromView, WithEvents, WithTitle
{
    use RegistersEventListeners;

    private $request;
    private $tlscores;
    private $months;

    public function __construct($request, $tlscores, $months)
    {

        $this->request = $request;
        $this->tlscores = $tlscores;
        $this->months = $months;
    }

    public function view(): View
    {
        return view('exports.reports.tl_summary',[
            'user_requests' =>  $this->request,
            'tlscores' => $this->tlscores,
            'months' => $this->months
           ]);
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return $sheetname = "DCO_TL_SCORECARD_SUMMARY";
    }
}



