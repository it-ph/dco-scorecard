<?php

namespace App\Imports;

use App\User;
use App\Setting;
use App\Position;
use Carbon\Carbon;
use App\Department;
use App\UserPositions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Scorecard\Agent as agentScoreCard;
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

        $this->row_number += 1;

        $agent = User::where('emp_id', $row['employee_number'])->where('role', 'agent')->where('status', 'active')->first();
        if($agent)
        {
            // dd('found');
            $agent_id = $agent->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell B". $this->row_number.", ". "Employee Number: ". $row['employee_number']. " not exist.");
            $ctr_error += 1;
        }

        $department = Department::where('department', $row['department'])->first();
        if($department)
        {
            // dd('found');
            $department_id = $department->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell D". $this->row_number.", ". "Department: ". $row['department']. " not exist.");
            $ctr_error += 1;
        }

        $position = Position::where('position', $row['position'])->first();
        if($position)
        {
            // dd('found');
            $position_id = $position->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell E". $this->row_number.", ". "Position: ". $row['position']. " not exist.");
            $ctr_error += 1;
        }

        if($department && $position)
        {
            $agent_position = UserPositions::where('user_id',$agent_id)->where('department_id', $department_id)->where('position_id', $position->id)->first();
            if($agent_position)
            {
                // dd('found');
                $agent_position_id = $agent_position->id;
            }
            else
            {
                array_push($this->has_error, "Check Cell D". $this->row_number.", ". "Department: ". $row['department']. " and Check Cell E". $this->row_number.", ". "Position: ". $row['position']. " does not match to any Employee Position record.");
                $ctr_error += 1;
            }
        }

        $month = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['month']))->format('M Y');

        $actual_productivity = $this->removePercent($row['productivity']);
        $actual_quality = $this->removePercent($row['quality']);
        $actual_reliability = $this->removePercent($row['reliability']);

        $target = Setting::where('setting','target')->first();
        $p = Setting::where('setting','productivity')->first();
        $q = Setting::where('setting','quality')->first();
        $r = Setting::where('setting','reliability')->first();

        $productivity = number_format((($p->value / 100) * $actual_productivity), 2);
        $quality = number_format((($q->value / 100) * $actual_quality), 2);
        $reliability = number_format((($r->value / 100) * $actual_reliability), 2);

        $productivity = $productivity > $p->value ? number_format($p->value, 2) : $productivity;
        $quality = $quality > $q->value ? number_format($q->value, 2) : $quality;
        $reliability = $reliability > $r->value ? number_format($r->value, 2) : $reliability;

        $final_score = number_format(($productivity + $quality + $reliability), 2);

        if($ctr_error <= 0)
        {
            agentScoreCard::updateOrCreate(
                [
                    'agent_id' => $agent_id,
                    'agent_position' => $agent_position_id,
                    'month' => $month,
                ],
                [
                    'target' => $target->value,
                    'actual_productivity' => $actual_productivity,
                    'actual_quality' => $actual_quality,
                    'actual_reliability' => $actual_reliability,
                    'productivity' => $productivity,
                    'quality' => $quality,
                    'reliability' => $reliability,
                    'final_score' => $final_score,
                    'acknowledge_by_agent' => 0,
                    'date_acknowledge_by_agent' => null,
                    'acknowledge_by_tl' => 0,
                    'date_acknowledge_by_tl' => null,
                    'acknowledge_by_manager' => 0,
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
            '*.department' => ['required'],
            '*.position' => ['required'],
            '*.quality' => ['required'],
            '*.productivity' => ['required'],
            '*.reliability' => ['required'],
        ];
    }
}
