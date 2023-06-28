<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/dco-scorecard.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{asset('css/google.font.css')}}" > --}}
    <style>
        body {
            color: black;
        }

        table {
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;

        }

        .lbl-bold {
            font-weight: bold
        }

        .ttxt-center {
            text-align: center;
        }

        @media print {
            .noprint {
                display: none;
            }
        }

        @media print {
            table {
                font-size: 12px !important;
            }
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
        <div class="row noprint" style="margin-top: 15px;">
            <div class="col-md-12">
                <button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm" onclick="goBack()"><i class="fa fa-chevron-left"></i> Back to Lists</button>
                <button type="button" title="Click to Print Scorecard" class="btn btn-info bt-sm pull-right" onclick="printThis()"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <table width="100%" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; text-align: center; font-weight: bold;font-size: 22px">@if($score->thetl->thedepartment)
                            {{strtoupper($score->thetl->thedepartment->department)}}
                            @endif - OPS SUPERVISOR</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Employee Name:</td>
                        <td>{{ucwords($score->thetl->name)}}</td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 18px;"> FINAL SCORE</span> </td>
                        <?php
                        $totalkpis = $score->quality + $score->productivity;
                        $totaldeliverables = $score->no_client_escalations + $score->no_pay_dispute + $score->linkedin_learning_compliance + $score->eod_reporting + $score->htl_compliance + $score->other_compliances_required;
                        // $final_reliablityscore = getTlReliabilityScore($score->reliability);
                        $final_score = $totalkpis + $totaldeliverables + $score->reliability;
                        ?>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$final_score}}%</span></td>
                        <!-- <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$score->final_score}}%</span></td> -->
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

            </div>
            <!--col-md-12-->
        </div>
        <!--row-->

        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="margin-top: 20px; font-size: 14px" cellspacing="5" cellpadding="5">
                    <tr style="background: gray; text-align: center; font-weight: bold;">
                        <td>METRICS</td>
                        <td>WEIGHT</td>
                        <td>TARGET</td>
                        <td colspan="2">PERFORMANCE RANGES</td>
                        <td>ACTUAL SCORE</td>
                        <td>SCORE</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="width: 200px" class="lbl-bold ttxt-center">Team KPIs</td>
                        <td rowspan="2" class="ttxt-center">40%</td>
                        <td rowspan="2" class="ttxt-center"><span>LOB-Specific KPIs</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                Passed Team Productivity (Weekly SLA)
                        </td>
                        <td class="ttxt-center lbl-bold">20%</td>
                        <td class="ttxt-center lbl-bold">{{$score->productivity}}%</td>
                        <td rowspan="2" class="ttxt-center lbl-bold">{{$totalkpis}}%</td>

                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                Passed Team Quality (Weekly SLA)
                        </td>
                        <td class="ttxt-center lbl-bold">20%</td>
                        <td class="ttxt-center lbl-bold">{{$score->quality}}%</td>
                    </tr>

                    <tr>
                        <td rowspan="6" style="width: 200px" class="lbl-bold ttxt-center">TL Deliverables</td>
                        <td rowspan="6" class="ttxt-center">50%</td>
                        <td rowspan="6" class="ttxt-center"><span>TL Specific action items</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                No client escalations
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                        <td class="ttxt-center lbl-bold">{{$score->no_client_escalations}}%</td>
                        <td rowspan="6" class="ttxt-center lbl-bold">{{$totaldeliverables}}%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                No or 1 pay dispute
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                        <td class="ttxt-center lbl-bold">{{$score->no_pay_dispute}}%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                Linkedin Learning Compliance
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                        <td class="ttxt-center lbl-bold">{{$score->linkedin_learning_compliance}}%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                EOD Reporting
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                        <td class="ttxt-center lbl-bold">{{$score->eod_reporting}}%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                HTL compliance
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                        <td class="ttxt-center lbl-bold">{{$score->htl_compliance}}%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                Other Compliance Required
                        </td>
                        <td class="ttxt-center lbl-bold">25%</td>
                        <td class="ttxt-center lbl-bold">{{$score->other_compliances_required}}%</td>
                    </tr>

                    <tr>
                        <td rowspan="4" style="width: 200px" class="lbl-bold ttxt-center">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                        <td rowspan="4" class="ttxt-center">10%</td>
                        <td rowspan="4" class="ttxt-center"><span>95% Over-all Reliability</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                >95% reliability
                        </td>
                        <td class="ttxt-center lbl-bold">10%</td>
                        <td rowspan="4" class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
                        <td rowspan="4" class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <95%>=90% reliability
                        </td>
                        <td class="ttxt-center lbl-bold">7%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <95%>=85% reliability
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                    </tr>
                    <tr>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                < 85% reliability </td> <td class="ttxt-center lbl-bold">0%</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                        <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$final_score}}%</td>
                    </tr>

                </table>
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->

        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; font-weight: bold">EMPLOYEE FEEDBACK:</td>
                    </tr>

                    <tr>
                        <td>
                            <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->feedback}}</textarea>
                        </td>
                    </tr>


                </table>

            </div>
            <!--col-md-12-->
        </div>
        <!--row-->

        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; font-weight: bold">ACTION PLAN/S:</td>
                    </tr>

                    <tr>
                        <td>
                            <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->action_plan}}</textarea>
                        </td>
                    </tr>


                </table>

            </div>
            <!--col-md-12-->
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <!--row-->
        <div class="row" style="margin-top: 20px">
            <div class="col-print-2"></div>
            <div class="col-print-4 text-center">
                <span style="font-weight: bold;">
                    @if($score->date_acknowledge_by_tl)
                    <img src="{{ asset('storage')}}/{{ $score->thetlsignature->user_id }}/signatures/{{$score->thetlsignature->file}}" alt="">
                    <br><i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> <small>{{ date('m/d/Y h:i:s a', strtotime($score->date_acknowledge_by_tl)) }}</small>
                    @else
                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                    @endif
                </span><br>
                <span style="text-decoration: underline; font-weight: bold;">{{strtoupper($score->thetl->name)}}</span>
                <br> <span style="font-weight: normal;font-size: 14px">Team Leader</span> </p>
            </div>
            <!--col-md-5-->

            <div class="col-print-6 text-center" @if($score->date_acknowledge_by_tl) style="margin-top: 98px" @endif>
                <span style="text-decoration: underline; font-weight: bold;">{{ date('m/d/Y h:i:s a') }}</span>
                <br> <span style="font-weight: normal;font-size: 14px">Date</span> </p>
            </div>
            <!--col-md-5-->
        </div>
        <!--row-->

        <div class="row" style="margin-top: 20px">
            <div class="col-print-2"></div>
            <div class="col-print-4 text-center">
                <span style="font-weight: bold;">
                    @if($score->date_acknowledge_by_manager)
                    <img src="{{ asset('storage')}}/{{ $score->themanagersignature->user_id }}/signatures/{{$score->themanagersignature->file}}" alt="">
                    <br><i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> <small>{{ date('m/d/Y h:i:s a', strtotime($score->date_acknowledge_by_manager)) }}</small>
                    @else
                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                    @endif
                </span>
                <span style="text-decoration: underline; font-weight: bold;">
                    @if(!empty($score->thenewManager))
                    <br> {{strtoupper($score->thenewManager->name)}}
                    @elseif($score->thetl->themanager)
                    <br> {{strtoupper($score->thetl->themanager->name)}}
                    @endif
                </span>
                <br> <span style="font-weight: normal;font-size: 14px">Operations Manager</span> </p>
            </div>
            <!--col-md-5-->


        </div>
        <!--row-->
        <div class="row" style="margin-top: 20px">
            <div class="col-print-1"></div>
            <div class="col-print-11 text-center">
                <span style="font-weight: bold;">
                    @if($score->date_acknowledge_by_towerhead)
                    <img src="{{ asset('storage')}}/{{ $score->thetowerheadsignature->user_id }}/signatures/{{$score->thetowerheadsignature->file}}" alt="">
                    <br><i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> <small>{{ date('m/d/Y h:i:s a', strtotime($score->date_acknowledge_by_towerhead)) }}</small>
                    @else
                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                    @endif
                </span><br>
                <span style="text-decoration: underline; font-weight: bold;">
                    {{ucwords($towerhead->value)}}
                </span>
                <br> <span style="font-weight: normal;font-size: 14px">Tower Head</span> </p>
            </div>
            <!--col-md-5-->
        </div>
        <!--row-->


    </div>
    <!--container-->
</body>

</html>

<script>
    window.print();

    function goBack() {
        window.history.back();
    }

    function printThis() {
        window.print();
    }
</script>