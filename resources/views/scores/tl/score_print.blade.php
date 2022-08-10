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
            <button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm" onclick="goBack()"><i class="fa fa-chevron-left"></i> Back to Lists</button>
            <button type="button" title="Click to Print Scorecard" class="btn btn-info bt-sm pull-right" onclick="printThis()"><i class="fa fa-print"></i> Print</button>
        </div>
        </div>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <table  width="100%"  cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; text-align: center; font-weight: bold;font-size: 22px">@if($score->thetl->thedepartment)
                            {{strtoupper($score->thetl->thedepartment->department)}}
                            @endif - OPS SUPERVISOR</td>
                    </tr>
                    
                    <tr>
                        <td class="lbl-bold">Employee Name:</td>
                        <td>{{ucwords($score->thetl->name)}}</td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 18px;"> FINAL SCORE</span> </td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$score->final_score}}%</span></td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Emp ID:</td>
                        <td>{{$score->thetl->emp_id}}</td>
                      
                    </tr>

                    <tr>
                        <td class="lbl-bold">Position</td>
                        <td>{{ucwords($score->thetl->theposition->position)}}</td>
                        <td class="lbl-bold">Month:</td>
                        <td>{{$score->month}}</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Department</td>
                        <td>{{ucwords($score->thetl->thedepartment->department)}}</td>
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
                        <td class="ttxt-center">20%</td>
                        <td class="ttxt-center"><span>95% Quality Monthly Average</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">20%</span> -  >= 95%  Quality Team average <br>
                            <span style="font-weight: 500">10%</span> -  80% to 94% quality average <br>
                            <span style="font-weight: 500">0%</span>  -  < 80% quality average </span> </td>
                        <td class="ttxt-center lbl-bold">{{$score->actual_quality}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score->quality}}%</td>
                    </tr>

                    <tr>
                        <td style="width: 200px" class="lbl-bold ttxt-center">PRODUCTIVITY</td>
                        <td class="ttxt-center">15%</td>
                        <td class="ttxt-center"><span>100% Team Productivity</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">15%</span> - >=100% Team Productivity<br>
                            <span style="font-weight: 500">5%</span> - 90% to 99% Team Productivity<br>
                            <span style="font-weight: 500">0%</span> - < 90% Team Productivity<br>
                            </span> </td>
                        <td class="ttxt-center lbl-bold">{{$score->actual_productivity}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score->productivity}}%</td>
                    </tr>

                    <tr>
                        <td style="width: 200px" class="lbl-bold ttxt-center">ADMIN & COACHING</td>
                        <td class="ttxt-center">30%</td>
                        <td class="ttxt-center"><span>All Met </span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">30%</span> - Met All Admin & Coaching Sessions<br>
                            <span style="font-weight: 500">0%</span> - Not Met</span> 
                        </td>
                        <td class="ttxt-center lbl-bold">{{$score->actual_admin_coaching}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score->admin_coaching}}%</td>
                    </tr>



                    <tr>
                        <td style="width: 200px" class="lbl-bold ttxt-center">TEAM PERFORMANCE</td>
                        <td class="ttxt-center">15%</td>
                        <td class="ttxt-center"><span>80%</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">15%</span> - >=95% Team Performance<br>
                            <span style="font-weight: 500">10%</span> - 90% to 95% Team Performance<br>
                            <span style="font-weight: 500">5%</span> - 80% to 90% Team Performance<br>
                            <span style="font-weight: 500">0%</span> - < 80% Team Performance<br>
                            </span> </td>
                        <td class="ttxt-center lbl-bold">{{$score->actual_team_performance}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score->team_performance}}%</td>
                    </tr>

                    <tr>
                        <td style="width: 200px" class="lbl-bold ttxt-center">INITIATIVE</td>
                        <td class="ttxt-center">5%</td>
                        <td class="ttxt-center"><span>All Met </span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">5%</span> - Met All Initiative Expectation<br>
                            <span style="font-weight: 500">0%</span> - Not Met</span> 
                        </td>
                        <td class="ttxt-center lbl-bold">{{$score->actual_initiative}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score->initiative}}%</td>
                    </tr>

                    <tr>
                        <td style="width: 200px" class="lbl-bold ttxt-center">TEAM ATTENDANCE <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                        <td class="ttxt-center">15%</td>
                        <td class="ttxt-center"><span>95% Over-all Reliability</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <span style="font-weight: 500">15%</span> - >=95% Reliability<br>
                                <span style="font-weight: 500">10%</span> - 90% to 95% Reliability<br>
                                <span style="font-weight: 500">5%</span> - 80% to 90% Reliability<br>
                                <span style="font-weight: 500">0%</span> - < 80% Reliability<br>
                            </span> </td>
                        <td class="ttxt-center lbl-bold">{{$score->actual_team_attendance}}%</td>
                        <td class="ttxt-center lbl-bold">{{$score->team_attendance}}%</td>
                    </tr>

                    <tr>
                        <td colspan="4"></td>
                        <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                        <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$score->final_score}}%</td>
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

                    <div class="row" style="margin-top: 20px">
                        <div class="col-print-2"></div>
                        <div class="col-print-4 text-center">
                            <span style="text-decoration: underline; font-weight: bold;">{{strtoupper($score->thetl->name)}}</span>
                            <br> <span style="font-weight: normal;font-size: 14px">Team Leader</span> </p>
                        </div><!--col-md-5-->

                        <div class="col-print-6 text-center">
                                <span style="text-decoration: underline; font-weight: bold;">{{strtoupper(date('m/d/Y'))}}</span>
                                <br> <span style="font-weight: normal;font-size: 14px">Date</span> </p>
                            </div><!--col-md-5-->
                    </div><!--row-->

                    <div class="row" style="margin-top: 20px">
                            <div class="col-print-2"></div>
                            <div class="col-print-4 text-center">
                                <span style="text-decoration: underline; font-weight: bold;">
                                    @if($score->thetl->themanager)
                                    {{strtoupper($score->thetl->themanager->name)}}
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
