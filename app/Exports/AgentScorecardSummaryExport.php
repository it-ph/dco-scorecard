<?php
namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class AgentScorecardSummaryExport implements FromView, WithEvents, WithTitle
{
    use RegistersEventListeners;

    private $request;
    private $agents;
    private $months;

    public function __construct($request, $agents, $months)
    {

        $this->request = $request;
        $this->agents = $agents;
        $this->months = $months;
    }

    public function view(): View
    {
        return view('exports.reports.agent_summary',[
            'user_requests' =>  $this->request,
            'agents' => $this->agents,
            'months' => $this->months
           ]);
    }

     /**
     * @return string
     */
    public function title(): string
    {


        // if($this->request['date_from'] == $this->request['date_to'] )
        // {
        //     $sheetname = "DCO_AGENT_SCORECARD_SUMMARY_". $this->request['date_from'] ;
        // }else{
        //     $sheetname = "DCO_AGENT_SCORECARD_SUMMARY_". $this->request['date_from'] .'_to_'.$this->request['date_to'];
        // }

        return $sheetname = "DCO_AGENT_SCORECARD_SUMMARY";
    }

    // public static function afterSheet(AfterSheet $event)
    // {
    //     $sheet = $event->sheet->getDelegate();

    //     $cells = array('A1','B1','C1','A2');
    //     foreach ($cells as $cell ) {
    //         $sheet->getStyle($cell)->getFont()
    //         ->setBold(true)
    //         ->getColor()->setRGB('ff0000');

    //         $sheet->setAutoSize(true);


    //     }
    // }
}
