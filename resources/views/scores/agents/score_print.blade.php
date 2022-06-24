<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/dco-scorecard.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{asset('css/google.font.css')}}" > --}}
    <style>
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
         table {font-size: 12px !important;}
        }

        .col-print-1 {width:8%;  float:left;}
        .col-print-2 {width:16%; float:left;}
        .col-print-3 {width:25%; float:left;}
        .col-print-4 {width:33%; float:left;}
        .col-print-5 {width:42%; float:left;}
        .col-print-6 {width:50%; float:left;}
        .col-print-7 {width:58%; float:left;}
        .col-print-8 {width:66%; float:left;}
        .col-print-9 {width:75%; float:left;}
        .col-print-10{width:83%; float:left;}
        .col-print-11{width:92%; float:left;}
        .col-print-12{width:100%; float:left;}
        
        
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
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$score->final_score}}%</span></td>
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
                    <table  width="100%" style="margin-top: 40px; font-size: 14px" cellspacing="5" cellpadding="5">
                        <tr  style="background: gray; text-align: center; font-weight: bold;">
                            <td>METRICS</td>
                            <td>WEIGHT</td>
                            <td>TARGET</td>
                            <td>PERFORMANCE RANGES</td>
                            <td>ACTUAL SCORE</td>
                            <td>SCORE</td>
                        </tr>
                        
                        <tr>
                            <td style="width: 200px" class="lbl-bold ttxt-center">QUALITY <br> (OVER-ALL)</td>
                            <td class="ttxt-center">40%</td>
                            <td class="ttxt-center"><span>95% <br>Quality <br>Monthly Average</span> </td>
                            <td style="text-align: justify; padding-left: 20px; width: 250px"><span>40% - >= 95% Quality average <br>
                                    30% - 85% to 94% quality average <br>
                                    15% - 80% to 84% quality average <br>
                                    0% - < 80% quality average </span> </td>
                            <td class="ttxt-center lbl-bold">{{$score->actual_quality}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score->quality}}%</td>
                        </tr>
    
                        <tr>
                            <td style="width: 200px" class="lbl-bold ttxt-center">PRODUCTIVITY</td>
                            <td class="ttxt-center">40%</td>
                            <td class="ttxt-center"><span>90% <br>Productivity <br> Average</span> </td>
                            <td style="text-align: justify; padding-left: 20px; width: 250px;">
                                <span>
                                40% - >=100% productivity average<br>
                                20% - 90% to 99% productivity average<br>
                                10% - 80% to 89% productivity average<br>
                                0% - < 80% productivity average<br>
                                </span> </td>
                            <td class="ttxt-center lbl-bold">{{$score->actual_productivity}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score->productivity}}%</td>
                        </tr>


                        <tr>
                            <td style="width: 200px" class="lbl-bold ttxt-center">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                            <td class="ttxt-center">40%</td>
                            <td class="ttxt-center"><span>95% <br>Over-all <br> Reliability</span> </td>
                            <td style="text-align: justify; padding-left: 20px; width: 250px"><span>
                                    20% - >=95% Reliability<br>
                                    15% - 90% to 94% Reliability<br>
                                    10% - 85% to 89% Reliability<br>
                                    5% - 80% to 84% Reliability<br>
                                    0% - < 80% Reliability<br>
                                </span> </td>
                            <td class="ttxt-center lbl-bold">{{$score->actual_reliability}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
                        </tr>

                        <tr>
                            <td colspan="4"></td>
                            <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                            <td class="ttxt-center lbl-bold">{{$score->final_score}}%</td>
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
                                @if($score->theagent->thesupervisor)
                                    {{strtoupper($score->theagent->thesupervisor->name)}}
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
                                    @if($score->theagent->themanager)
                                        {{strtoupper($score->theagent->themanager->name)}}
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

<script>
     window.print();
     
    function goBack() {
        window.history.back();
    }

    function printThis(){
        window.print();
    }
</script>
