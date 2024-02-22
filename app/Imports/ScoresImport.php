<?php

namespace App\Imports;

use App\User;
use App\Setting;
use App\Scorecard\Agent as agentScoreCard;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScoresImport implements ToModel, WithHeadingRow, WithValidation,SkipsEmptyRows
{
    private $has_error = array();
    private $row_number = 1;
    public function model(array $row)
    {
        $ctr_error = 0;
        array_push($this->has_error,"Something went wrong, Please check all entries that you have encoded.");

        $agent = User::where('emp_id', $row['employee_number'])->where('role', 'agent')->where('status', 'active')->select('id','supervisor','manager')->first();

        // dd($agent);
        $this->row_number += 1;

        if(strtolower($row['month_type']) == 'mid' || strtolower($row['month_type']) == 'end')
        {
            $month_type = $row['month_type'];
        }
        else
        {
            array_push($this->has_error, "Check Cell A". $this->row_number.", ". "Month Type: ". $row['month_type']. " is invalid.");
            $ctr_error += 1;
        }

        if($agent->count() > 0)
        {
            // dd('found');
            $agent_id = $agent->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell C". $this->row_number.", ". "Employee Number: ". $row['employee_number']. " not exist.");
            $ctr_error += 1;
        }

        $month = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['month']))->format('M Y');

        $actual_productivity = $this->removePercent($row['productivity']);
        $actual_quality = $this->removePercent($row['quality']);
        $actual_reliability = $this->removePercent($row['reliability']);
        $actual_profit= $this->removePercent($row['profit']);
        $actual_engagement= $this->removePercent($row['engagement']);
        $actual_behavior= $this->removePercent($row['behavior']);
        $actual_partnership= $this->removePercent($row['partnership']);
        $actual_priority= $this->removePercent($row['priority']);

        $target = Setting::where('setting','target')->first();
        $p = Setting::where('setting','productivity')->first();
        $q = Setting::where('setting','quality')->first();
        $r = Setting::where('setting','reliability')->first();
        $pt = Setting::where('setting','profit')->first();
        $e = Setting::where('setting','engagement')->first();
        $b = Setting::where('setting','behavior')->first();
        $ps = Setting::where('setting','partnership')->first();
        $py = Setting::where('setting','priority')->first();

        $productivity = number_format((($p->value / 100) * $actual_productivity), 2);
        $quality = number_format((($q->value / 100) * $actual_quality), 2);
        $reliability = number_format((($r->value / 100) * $actual_reliability), 2);
        $profit = number_format((($pt->value / 100) * $actual_profit), 2);
        $engagement = number_format((($e->value / 100) * $actual_engagement), 2);
        $behavior = number_format((($b->value / 100) * $actual_behavior), 2);
        $partnership = number_format((($ps->value / 100) * $actual_partnership), 2);
        $priority = number_format((($py->value / 100) * $actual_priority), 2);

        $productivity = $productivity > $p->value ? number_format($p->value, 2) : $productivity;
        $quality = $quality > $q->value ? number_format($q->value, 2) : $quality;
        $reliability = $reliability > $r->value ? number_format($r->value, 2) : $reliability;
        $profit = $profit > $pt->value ? number_format($pt->value, 2) : $profit;
        $engagement = $engagement > $e->value ? number_format($e->value, 2) : $engagement;
        $partnership = $partnership > $ps->value ? number_format($ps->value, 2) : $partnership;
        $priority = $priority > $py->value ? number_format($py->value, 2) : $priority;

        $final_score = number_format(($productivity + $quality + $reliability + $profit + $engagement + $partnership + $priority), 2);

        if($ctr_error <= 0)
        {
            agentScoreCard::updateOrCreate(
                [
                    'agent_id' => $agent_id,
                    'month_type' => $month_type,
                    'month' => $month,
                ],
                [
                    'target' => $target->value,
                    'actual_productivity' => $actual_productivity,
                    'actual_quality' => $actual_quality,
                    'actual_reliability' => $actual_reliability,
                    'actual_profit' => $actual_profit,
                    'actual_engagement' => $actual_engagement,
                    'actual_behavior' => $actual_behavior,

                    'productivity' => $productivity,
                    'quality' => $quality,
                    'reliability' => $reliability,
                    'profit' => $profit,
                    'engagement' => $engagement,
                    'behavior' => $behavior,
                    'partnership' => $partnership,
                    'priority' => $priority,

                    'final_score' => $final_score,
                    'acknowledge_by_agent' => 0,
                    'date_acknowledge_by_agent' => null,
                    'acknowledge_by_tl' => 0,
                    'new_tl_id' => $agent->supervisor,
                    'date_acknowledge_by_tl' => null,
                    'acknowledge_by_manager' => 0,
                    'new_manager_id' => $agent->manager,
                    'date_acknowledge_by_manager' => null,
                ]
            );
        }
    }

    public function getErrors()
    {
        return $this->has_error;
    }

    public function removePercent($val)
    {
        $a =  str_replace("%","",$val);
        $b = str_replace("%","",$a);

        return $b;
    }

    public function rules(): array
    {
        return [
            '*.month' => ['required'],
            '*.employee_number' => ['required'],
            '*.employee_name' => ['required'],
            '*.quality' => ['required'],
            '*.productivity' => ['required'],
            '*.reliability' => ['required'],
            '*.profit' => ['required'],
            '*.engagement' => ['required'],
            '*.behavior' => ['required'],
            '*.partnership' => ['required'],
            '*.priority' => ['required']
        ];
    }
}
