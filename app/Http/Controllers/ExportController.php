<?php

namespace App\Http\Controllers;

use App\User;
use App\Scorecard\Agent as agentScoreCard;
use App\Scorecard\tl as TLScoreCard;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UploadAgentTemplateExport;
use App\Exports\UploadTLTemplateExport;
use App\Exports\AgentScorecardSummaryExport;
use App\Exports\TlScorecardSummaryExport;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $this->validate($request,
            [
                'report' => 'required',
                'date_from' => 'required',
                'date_to' => 'required',
            ],
            $messages = array(
                'report.required' => 'Please Select Report!',
                'date_from.required' => 'Date From is Required!',
                'date_to.required' => 'Date To is Required!'
            )
        );

        if($request['report'] == 'agent')
        {
            return $this->exportAgentScorecardSummary($request);
        }
        elseif($request['report'] == 'tl')
        {
            return $this->exportTlScorecardSummary($request);

            // $tl  = tlScoreCard::whereBetween('month', [$date_from, $date_to])->get();
        }
    }
    public function exportAgentScorecardSummary(Request $request)
    {
        $date_from = $request['date_from'];
        $date_to = $request['date_to'];

        $agents = User::where('role','agent')->orderBy('name','ASC')->get();

        $months = CarbonPeriod::create($date_from, '1 month', $date_to);

        // $agent = agentScoreCard::whereBetween('month', [$date_from, $date_to])->get();

        if($request['date_from'] == $request['date_to'] )
        {
            $filename = "DCO_AGENT_SCORECARD_SUMMARY_". $request['date_from'] .".xlsx";

        }else{
            $filename = "DCO_AGENT_SCORECARD_SUMMARY_". $request['date_from'] .'_to_'.$request['date_to'].".xlsx";

        }

        return Excel::download(new AgentScorecardSummaryExport($request, $agents, $months),  $filename);
    }
    public function uploadAgentTemplate()
    {
        return Excel::download(new UploadAgentTemplateExport, 'DCO-upload-agent_template.xlsx');
    }

    public function uploadTLTemplate()
    {
        return Excel::download(new UploadTLTemplateExport, 'DCO-upload-tl_template.xlsx');
    }

    public function exportTlScorecardSummary(Request $request)
    {
        $date_from = $request['date_from'];
        $date_to = $request['date_to'];

        $tlscores = User::where('role','supervisor')->orderBy('name','ASC')->get();

        $months = CarbonPeriod::create($date_from, '1 month', $date_to);

        // $agent = agentScoreCard::whereBetween('month', [$date_from, $date_to])->get();

        if($request['date_from'] == $request['date_to'] )
        {
            $filename = "DCO_TL_SCORECARD_SUMMARY_". $request['date_from'] .".xlsx";

        }else{
            $filename = "DCO_TL_SCORECARD_SUMMARY_". $request['date_from'] .'_to_'.$request['date_to'].".xlsx";

        }

        return Excel::download(new TlScorecardSummaryExport($request, $tlscores, $months),  $filename);
    }
}
