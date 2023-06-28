<?php

namespace App\Imports;

use App\User;
use App\Setting;
use App\Scorecard\tl as tlScoreCard;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TLScoresImport implements ToModel, WithHeadingRow, WithValidation,SkipsEmptyRows
{
    private $has_error = array();
    private $row_number = 1;
    public function model(array $row)
    {
        $ctr_error = 0;
        array_push($this->has_error,"Something went wrong, Please check all entries that you have encoded.");

        $teamlead = User::where('emp_id', $row['employee_number'])->where('role', 'supervisor')->where('status', 'active')->select('id','manager')->first();

        $this->row_number += 1;
        $month = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['month']))->format('M Y');
        if($teamlead->count() > 0)
        {
            // dd('found');
            $tl_id = $teamlead->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell B". $this->row_number.", ". "Employee Number: ". $row['employee_number']. " not exist.");
            $ctr_error += 1;
        }


        $productivity = $this->removePercent($row['productivity']);
        $quality = $this->removePercent($row['quality']);
        $no_client_escalations = $this->removePercent($row['no_client_escalations']);
        $no_pay_dispute = $this->removePercent($row['no_pay_dispute']);
        $linkedin_learning_compliance = $this->removePercent($row['linkedin_learning_compliance']);
        $eod_reporting = $this->removePercent($row['eod_reporting']);
        $htl_compliance = $this->removePercent($row['htl_compliance']);
        $other_compliances_required = $this->removePercent($row['other_compliances_required']);
        $reliability = $this->removePercent($row['reliability']);

        $target = Setting::where('setting','target')->first();

        $final_score = number_format(($productivity + $quality + 
                                    $reliability + $no_client_escalations + $no_pay_dispute +
                                    $linkedin_learning_compliance +
                                    $eod_reporting + 
                                    $htl_compliance + 
                                    $other_compliances_required ), 2);

        if($ctr_error <= 0)
        {
            tlScoreCard::updateOrCreate(
                [
                    'tl_id' => $tl_id,
                    'month' => $month,
                ],
                [
                    'target' => $target->value,
                    'quality' => $quality,
                    'productivity' => $productivity,
                    'no_client_escalations' => $no_client_escalations,
                    'no_pay_dispute' => $no_pay_dispute,
                    'linkedin_learning_compliance' => $linkedin_learning_compliance,
                    'eod_reporting' => $eod_reporting,
                    'htl_compliance' => $htl_compliance,
                    'other_compliances_required' => $other_compliances_required,
                    'reliability' => $reliability,
                    'final_score' => $final_score,
                    'new_manager_id' => $teamlead->manager,
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
            '*.no_client_escalations' => ['required'],
            '*.no_pay_dispute' => ['required'],
            '*.linkedin_learning_compliance' => ['required'],
            '*.eod_reporting' => ['required'],
            '*.htl_compliance' => ['required'],
            '*.other_compliances_required' => ['required'],
            '*.reliability' => ['required'],
        ];
    }
}
