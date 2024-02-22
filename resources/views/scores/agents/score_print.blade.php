<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/dco-scorecard.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{asset('css/google.font.css')}}" > --}}
    <style nonce="{{csp_nonce()}}">
        body{
            color: black;
        }

        table {
        border-collapse: collapse;
        }
        td, th {
        border: 1px solid black;

        }
        .lbl-bold{
            font-weight: bold
        }

        .ttxt-center{
            text-align: center;
        }

        @media print
        {
        .noprint {display:none;}
        }

        @media print
        {
            .container { margin: 0; }
         table {font-size: 12px !important;}
        }

        .col-print-1 {
            width: 8%;
            float: left;
        }

        .col-print-2 {
            width: 16%;
            float: left;
        }

        .col-print-3 {
            width: 25%;
            float: left;
        }

        .col-print-4 {
            width: 33%;
            float: left;
        }

        .col-print-5 {
            width: 42%;
            float: left;
        }

        .col-print-6 {
            width: 50%;
            float: left;
        }

        .col-print-7 {
            width: 58%;
            float: left;
        }

        .col-print-8 {
            width: 66%;
            float: left;
        }

        .col-print-9 {
            width: 75%;
            float: left;
        }

        .col-print-10 {
            width: 83%;
            float: left;
        }

        .col-print-11 {
            width: 92%;
            float: left;
        }

        .col-print-12 {
            width: 100%;
            float: left;
        }




    </style>
    <title>DCO Scorecard</title>
</head>
<body>
    <div class="container">
        <div class="row noprint" style="margin-top: 20px;">
            <div class="col-md-12">
            <button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm" onclick="goBack()"><i class="fa fa-chevron-left"></i> Back to Scorecard</button>
            <button type="button" title="Click to Print Scorecard" class="btn btn-info bt-sm pull-right" onclick="printThis()"><i class="fa fa-print"></i> Print</button>
        </div>
        </div>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <table  width="100%"  cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; text-align: center; font-weight: bold;font-size: 22px">@if($score->theagent->thedepartment)
                            {{strtoupper($score->theagent->thedepartment->department)}}
                            @endif - AGENT</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Employee Name:</td>
                        <td>{{ucwords($score->theagent->name)}}</td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 18px;"> FINAL SCORE</span> </td>
                        <?php
                            // $score_quality = $score->quality;
                            // $score_remarks = $score->actual_remarks;
                            $score_quality_remarks = $score->quality_remarks;
                            $score_productivity_remarks = $score->productivity_remarks;
                            $score_profit_remarks = $score->profit_remarks;
                        //    $score_people_remarks = $score->people_remarks;
                            $score_engagement_remarks = $score->engagement_remarks;
                            $score_behavior_remarks = $score->behavior_remarks;
                            $score_partnership_remarks = $score->partnership_remarks;
                            $score_priority_remarks = $score->priority_remarks;
                            $score_reliability_remarks = $score->reliability_remarks;

                            $score_quality = getAgentQualityScore($score->actual_quality); //implement new quality performance range july 20, 2022
                            $score_productivity = $score->productivity;
                            $score_profit = getAgentProfitScore($score->actual_profit);
                        //    $score_people = getAgentPeopleScore($score->actual_people);
                            $score_engagement = getAgentPeopleEngScore($score->actual_engagement);
                            $score_behavior = getAgentPeopleBehScore($score->actual_behavior);
                            $score_partnership = getAgentPartnershipScore($score->actual_partnership);
                            $score_priority = getAgentPriorityScore($score->actual_priority);
                            $score_reliability = getAgentReliabilityScore($score->actual_reliability);
                            $final_score = $score_quality + $score_productivity + $score_reliability + $score_profit + $score_engagement + $score_behavior + $score_partnership + $score_priority;
                        ?>
                        {{-- <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$score->final_score}}%</span></td> --}}
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$final_score}}%</span></td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Emp ID:</td>
                        <td>{{$score->theagent->emp_id}}</td>

                    </tr>

                    <tr>
                        <td class="lbl-bold">Position</td>
                        <td>{{ucwords($score->theagent->theposition->position)}}</td>
                        <td class="lbl-bold">Month:</td>
                        <td>{{$score->month}}</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Department</td>
                        <td>{{ucwords($score->theagent->thedepartment->department)}}</td>
                        <td class="lbl-bold">Target:</td>
                        <td>{{$score->target}}%</td>
                    </tr>
                </table>

            </div><!--col-md-12-->
        </div><!--row-->

        <div class="row">
                <div class="col-md-12">
                    <table  width="100%" style="margin-top: 40px; font-size: 11px" cellspacing="5" cellpadding="5">
                        <tr  style="background: gray; text-align: center; font-weight: bold;">
                            <td>KRA</td>
                            <td>GOAL</td>
                            <td>GOAL DESCRIPTION</td>
                            <td>WEIGHTAGE</td>
                            <td>TARGET/PERFORMANCE RANGE</td>
                            <td>SELF ASSESSMENT RATING</td>
                            <td>EMPLOYEE REMARKS</td>
                            <td>METRICS</td>
                            <td>WEIGHT</td>
                            <td>TARGET</td>
                            <td>PERFORMANCE RANGES</td>
                            <td>ACTUAL SCORE</td>
                            <td>SCORE</td>
                        </tr>

                        <tr>
                            <!--start 1st column-->
                            <td rowspan="3" style="width: 200px" class="lbl-bold ttxt-center">Performance</td>
                            <td class="ttxt-center">Quality</td>
                            <td class="ttxt-center">Individual Productivity Performance Output</td>
                            <td class="ttxt-center">25.00%</td>
                            <td style="text-align: center; width: 350px;  font-style: italic">
                                <span style="font-weight: 500">25%</span> -  95% above Quality average <br>
                                <span style="font-weight: 500">20%</span> -  90% to 94.99% Quality average <br>
                                <span style="font-weight: 500">15%</span> -  85% to 89.99% Quality average <br>
                                <span style="font-weight: 500">5%</span> -  80% to 84.99% Quality average <br>
                                <span style="font-weight: 500">0%</span>  -  79.99% below Quality average </span>
                            </td>
                            <td class="ttxt-center lbl-bold">25.00%</td>
                            <td>{{$score_quality_remarks}}</td>
                            <!--end 1st column-->

                            <td style="width: 200px" class="lbl-bold ttxt-center">QUALITY <br> (OVER-ALL)</td>
                            <td class="ttxt-center">25%</td>
                            <td class="ttxt-center"><span>95% <br>Quality <br>Monthly Average</span> </td>
                            <td style="text-align: center; width: 350px;  font-style: italic">
                                <span style="font-weight: 500">25%</span> -  95% above Quality average <br>
                                <span style="font-weight: 500">20%</span> -  90% to 94.99% Quality average <br>
                                <span style="font-weight: 500">15%</span> -  85% to 89.99% Quality average <br>
                                <span style="font-weight: 500">5%</span> -  80% to 84.99% Quality average <br>
                                <span style="font-weight: 500">0%</span>  -  79.99% below Quality average </span>
                            </td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_quality,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_quality}}%</td>
                        </tr>

                        <tr>
                            <!--start 2nd column-->
                            <td class="ttxt-center">Productivity</td>
                            <td class="ttxt-center">Individual Productivity Performance Output</td>
                            <td class="ttxt-center">12.50.00%</td>
                            <td style="text-align: center;  width: 350px;  font-style: italic">100% Productivity Average</td>
                            <td class="ttxt-center lbl-bold">12.50%</td>
                            <td>{{$score_productivity_remarks}}</td>
                            <!--end 2nd column-->

                            <td style="width: 200px" class="lbl-bold ttxt-center">PRODUCTIVITY</td>
                            <td class="ttxt-center">12.5%</td>
                            <td class="ttxt-center"><span>90% <br>Productivity <br> Average</span> </td>
                            <td style="text-align: center;  width: 350px;  font-style: italic">100% Productivity Average</td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_productivity,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_productivity}}%</td>
                        </tr>

                        <tr>
                            <!--start 3rd column-->
                            <td class="ttxt-center">Reliability</td>
                            <td class="ttxt-center">Attendance Performance</td>
                            <td class="ttxt-center">12.50%</td>
                            <td style="text-align: center; width: 350px;  font-style: italic">
                                <span style="font-weight: 500">12.50%</span> -  95% Reliability <br>
                                <span style="font-weight: 500">8%</span> -  90% Reliability <br>
                                <span style="font-weight: 500">5%</span> -  85% to 89% Reliability <br>
                                <span style="font-weight: 500">2%</span> -  80% to 84% Reliability <br>
                                <span style="font-weight: 500">0%</span>  -  < 80% Reliability </span>
                            </td>
                            <td class="ttxt-center lbl-bold">12.50%</td>
                            <td>{{$score_reliability_remarks}}</td>
                            <!--end 3rd column-->

                            <td style="width: 200px" class="lbl-bold ttxt-center">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                            <td class="ttxt-center">12.50%</td>
                            <td class="ttxt-center"><span>95% <br>Over-all <br> Reliability</span> </td>
                            <td style="text-align: center; width: 350px;  font-style: italic">
                                <span style="font-weight: 500">12.50%</span> -  95% Reliability <br>
                                <span style="font-weight: 500">8%</span> -  90% Reliability <br>
                                <span style="font-weight: 500">5%</span> -  85% to 89% Reliability <br>
                                <span style="font-weight: 500">2%</span> -  80% to 84% Reliability <br>
                                <span style="font-weight: 500">0%</span>  -  < 80% Reliability </span>
                            </td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_reliability,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_reliability}}%</td>
                        </tr>

                        <tr>
                        <!--start 4th column-->
                        <td style="width: 200px" class="lbl-bold ttxt-center">Profit</td>
                        <td class="ttxt-center">Escalation</td>
                        <td class="ttxt-center">No client escalation</td>
                        <td class="ttxt-center">10.00%</td>
                        <td style="text-align: center;  width: 350px;  font-style: italic">
                            <span style="font-weight: 500">10%</span> - No client escalation<br>
                            <span style="font-weight: 500">5%</span> - without monetary impact<br>
                            <span style="font-weight: 500">10%</span> - With monetary impact<br>
                        </td>
                        <td class="ttxt-center lbl-bold">10.00%</td>
                        <td>{{$score_profit_remarks}}</td>
                        <td></td>
                        <td class="ttxt-center">10%</td>
                        <td></td>
                        <td style="text-align: center;  width: 350px;  font-style: italic">
                            <span style="font-weight: 500">10%</span> - No client escalation<br>
                            <span style="font-weight: 500">5%</span> - without monetary impact<br>
                            <span style="font-weight: 500">10%</span> - With monetary impact<br>
                        </td>
                        <td class="ttxt-center lbl-bold">{{number_format($score->actual_profit,2)}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score_profit}}%</td>
                        <!--end 4th column-->
                    </tr>

                        <tr>
                            <!--start 5th column-->
                            <td rowspan="2" style="width: 200px" class="lbl-bold ttxt-center">People</td>
                            <td class="ttxt-center">Engagement Participation</td>
                            <td class="ttxt-center">Client, Tower and Personiv Engagement Attendance</td>
                            <td class="ttxt-center">15.00%</td>
                            <td style="text-align: center; width: 350px;  font-style: italic">100% Compliance</td>
                            <td class="ttxt-center lbl-bold">15.00%</td>
                            <td>{{$score_engagement_remarks}}</td>
                            <td></td>
                            <td class="ttxt-center">15%</td>
                            <td></td>
                            <td style="text-align: center; width: 350px;  font-style: italic">100% Compliance</td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_engagement,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_engagement}}%</td>
                        </tr>

                        <tr>
                            <td class="ttxt-center">Behavioral Attributes</td>
                            <td class="ttxt-center">Personal Behavioral Attributes</td>
                            <td class="ttxt-center">10.00%</td>
                            <td style="text-align: center; width: 350px;  font-style: italic">
                                <span style="font-weight: 500">NTEs</span><br>
                                <span style="font-weight: 500">Not filing/checking timekeeping</span><br>
                                <span style="font-weight: 500">TMS Tracker</span><br>
                                <span style="font-weight: 500">etc</span>
                            </td>
                            <td class="ttxt-center lbl-bold">10.00%</td>
                            <td>{{$score_behavior_remarks}}</td>
                            <td></td>
                            <td class="ttxt-center">5%</td>
                            <td></td>
                            <td style="text-align: center; width: 350px;  font-style: italic">
                                <span style="font-weight: 500">NTEs</span><br>
                                <span style="font-weight: 500">Not filing/checking timekeeping</span><br>
                                <span style="font-weight: 500">TMS Tracker</span><br>
                                <span style="font-weight: 500">etc</span>
                            </td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_behavior,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_behavior}}%</td>
                        </tr>

                        <tr>
                            <!--start 5th column-->
                            <td style="width: 200px" class="lbl-bold ttxt-center">Partnership</td>
                            <td class="ttxt-center">Client Appreciation</td>
                            <td class="ttxt-center">Client Feedback, mentions, kudos, and commendations</td>
                            <td class="ttxt-center">5.00%</td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                <span>All or nothing</span>
                            </td>
                            <td class="ttxt-center lbl-bold">5.00%</td>
                            <td>{{$score_partnership_remarks}}</td>
                            <td></td>
                            <td class="ttxt-center">5%</td>
                            <td></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                <span>All or nothing</span>
                            </td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_parnership,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_partnership}}%</td>
                            <!--end 5th column-->
                        </tr>

                        <tr>
                            <!--start 5th column-->
                            <td style="width: 200px" class="lbl-bold ttxt-center">Priority</td>
                            <td class="ttxt-center">Special Projects</td>
                            <td class="ttxt-center">Adhoc assignments like Personiv surveys, etc</td>
                            <td class="ttxt-center">10.00%</td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                <span style="font-weight: 500"></span> Rewards hub posting  <br>
                                <span style="font-weight: 500"></span> BCP Kit Testing  <br>
                                <span style="font-weight: 500"></span> Surveys  <br>
                                <span style="font-weight: 500"></span> etc  <br>
                            </td>
                            <td class="ttxt-center lbl-bold">5.00%</td>
                            <td>{{$score_priority_remarks}}</td>
                            <td></td>
                            <td class="ttxt-center">10%</td>
                            <td></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                <span style="font-weight: 500"></span> Rewards hub posting  <br>
                                <span style="font-weight: 500"></span> BCP Kit Testing  <br>
                                <span style="font-weight: 500"></span> Surveys  <br>
                                <span style="font-weight: 500"></span> etc  <br>
                            </td>
                            <td class="ttxt-center lbl-bold">{{number_format($score->actual_priority,2)}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score_priority}}%</td>
                            <!--end 5th column-->
                        </tr>

                        <tr>
                            <td colspan="3" class="ttxt-center lbl-bold">Average</td>
                            <td class="ttxt-center lbl-bold">100%</td>
                            <td colspan="7"></td>
                            <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                            <?php $total_score = $score_quality + $score_productivity + $score_reliability + $score_profit + $score_engagement + $score_behavior + $score_partnership + $score_priority; ?>
                            <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$total_score}}%</td>
                        </tr>

                    </table>
                </div><!--col-md-12-->
            </div><!--row-->

            <div class="row">
                    <div class="col-md-12">
                        <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                            <tr>
                                <td colspan="4" style="background: gray; font-weight: bold">EMPLOYEE FEEDBACK:</td>
                            </tr>

                            <tr>
                                <td>
                                    <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->agent_feedback}}</textarea>
                                </td>
                            </tr>


                        </table>

                    </div><!--col-md-12-->
                </div><!--row-->

                <div class="row">
                    <div class="col-md-12">
                        <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                            <tr>
                                <td colspan="4" style="background: gray; font-weight: bold">ACTION PLAN/S:</td>
                            </tr>

                            <tr>
                                <td>
                                    <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->action_plan}}</textarea>
                                </td>
                            </tr>


                        </table>

                    </div><!--col-md-12-->
                </div><!--row-->

                <div class="row">
                    <div class="col-md-12">
                        <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                            <tr>
                                <td colspan="4" style="background: gray; font-weight: bold">STRENGTHS AND OPPORTUNITIES:</td>
                            </tr>

                            <tr>
                                <td>
                                    <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->opportunities_strengths}}</textarea>
                                </td>
                            </tr>


                        </table>

                    </div><!--col-md-12-->
                </div><!--row-->

                <div class="row">
                    <div class="col-md-12">
                        <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                            <tr>
                                <td colspan="4" style="background: gray; font-weight: bold">SCREENSHOT/S:</td>
                            </tr>

                            <tr>
                                <td>
                                    {{-- <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->screenshots}}</textarea> --}}
                                    <p>
                                        @if($score->screenshots)
                                            <?php $screenshots = str_replace('<img', '<img style="height: 100%; width: 100%; object-fit: contain; padding: 0 2px"', $score->screenshots); ?>
                                            {!! $screenshots !!}
                                        @endif
                                    </p>
                                </td>
                            </tr>


                        </table>

                    </div><!--col-md-12-->
                </div><!--row-->

                {{-- SIGNATORIES --}}

                <div class="row" style="margin-top: 20px">
                    <div class="col-print-2"></div>
                    <div class="col-print-4 text-center">
                        @if($score->date_acknowledge_by_agent)
                            <img src="{{ asset('storage')}}/{{ $score->theagentsignature->user_id }}/signatures/{{$score->theagentsignature->file}}" alt="">
                            <br><small>{{ $score->date_acknowledge_by_agent->format('m/d/Y h:i:s a') }}</small>
                        @endif
                        <br> <span style="text-decoration: underline; font-weight: bold;">{{strtoupper($score->theagent->name)}}</span>
                        <br> <span style="font-weight: normal;font-size: 14px">Agent Name</span> </p>
                    </div><!--col-md-5-->

                    <div class="col-print-6 text-center" @if($score->date_acknowledge_by_agent) style="margin-top: 98px" @endif>
                            <span style="text-decoration: underline; font-weight: bold;">{{strtoupper(date('m/d/Y'))}}</span>
                            <br> <span style="font-weight: normal;font-size: 14px">Date</span> </p>
                        </div><!--col-md-5-->
                </div><!--row-->

                <div class="row" style="margin-top: 20px">
                        <div class="col-print-2"></div>
                        <div class="col-print-4 text-center">
                            @if($score->date_acknowledge_by_tl)
                                <img src="{{ asset('storage')}}/{{ $score->thetlsignature->user_id }}/signatures/{{$score->thetlsignature->file}}" alt="">
                                <br><small>{{ $score->date_acknowledge_by_agent->format('m/d/Y h:i:s a') }}</small>
                            @endif
                            <br> <span style="text-decoration: underline; font-weight: bold;">
                                @if(!empty($score->thenewTl))
                                    <br> {{strtoupper($score->thenewTl->name)}}
                                @elseif($score->theagent->thesupervisor)
                                    <br> {{strtoupper($score->theagent->thesupervisor->name)}}
                                @endif
                            </span>
                            <br> <span style="font-weight: normal;font-size: 14px">Supervisor</span> </p>
                        </div><!--col-md-5-->

                        <div class="col-print-6 text-center">
                                @if($score->date_acknowledge_by_manager)
                                    <img src="{{ asset('storage')}}/{{ $score->themanagersignature->user_id }}/signatures/{{$score->themanagersignature->file}}" alt="">
                                    <br><small>{{ $score->date_acknowledge_by_agent->format('m/d/Y h:i:s a') }}</small>
                                @endif
                                <br> <span style="text-decoration: underline; font-weight: bold;">
                                @if(!empty($score->thenewManager))
                                    <br> {{strtoupper($score->thenewManager->name)}}        
                                @elseif($score->theagent->themanager)
                                    <br> {{strtoupper($score->theagent->themanager->name)}}
                                @endif
                                </span>
                                <br> <span style="font-weight: normal;font-size: 14px">Operations Manager</span> </p>
                            </div><!--col-md-5-->
                </div><!--row-->
                <div class="row" style="margin-top: 20px">
                        <div class="col-print-1"></div>
                        <div class="col-print-11 text-center">
                                <span style="text-decoration: underline; font-weight: bold;">
                                    {{ucwords($towerhead->value)}}
                                </span>
                                <br> <span style="font-weight: normal;font-size: 14px">Tower Head</span> </p>
                            </div><!--col-md-5-->
                </div><!--row-->

    </div><!--container-->
</body>
</html>

<script nonce="{{csp_nonce()}}">
     window.print();

    function goBack() {
        window.history.back();
    }

    function printThis(){
        window.print();
    }
</script>
