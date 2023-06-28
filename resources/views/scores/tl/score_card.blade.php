@extends('layouts.dco-app')
@section('css')
<style>
    table {
        color: black;
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
@endsection
@section('content')
<div class="container-fluid">
    <div class="row noprint" style="margin-top: 20px;">
        <div class="col-md-12">
            <a href="{{url('scores/tl')}}">
                <button type="button" title="Click to go back to Lists" class="btn btn-success"><i class="fa fa-chevron-left"></i> Back to Lists</button>
            </a>


            <form method="GET" action="{{route('tl-score.print', ['id' => $score->id])}}">
                <button type="submit" title="Click to Print Scorecard" style="margin-top: 10px; margin-right: 10px" class="btn btn-info btn-sm pull-left"><i class="fa fa-print"></i> Print</button>
            </form>
            @if(Auth::user()->isAdmin())
            <form method="GET" action="{{route('tl-score.edit', ['id' => $score->id])}}">
                <button class="btn btn-primary btn-sm  pull-left" style="margin-top: 10px">
                    <i class="fa fa-pencil"></i> Edit
                </button>
            </form>
            {{-- <a href="{{url('scores/agent/'.$score->id.'?from_show')}}"> <button class="btn btn-primary btn-sm  pull-left" style="margin-top: 10px">
                <i class="fa fa-pencil"></i> Edit
            </button>
            </a> --}}
            @endif

            @if(Auth::user()->isAdmin())
            @if($score->acknowledge_by_tl == "0" || $score->acknowledge_by_manager == "0")
            @if($score->acknowledge_by_tl == "0")
            <form method="POST" action="{{route('tl-acknowledge.store',['id' => $score->id])}}" id="acknowledgeScorecardForm">
                @csrf
            </form>
            @if(Auth::user()->thesignatures->count() > 0)
            <a class="btn btn-warning btn pull-right" onclick="acknowledgeScorecard()" href="#" title="Acknowledge Scorecard"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @else
            <a class="btn btn-warning btn pull-right" oncliccreateSignatureard()" href="#" titlPlease create signatureard"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @endif
            @elseif($score->acknowledge_by_agent == "0" && $score->acknowledge_by_tl == "0")
            <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
            @else
            <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
            @endif
            @else
            <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
            @endif
            @elseif(Auth::user()->isSupervisor())
            @if($score->acknowledge_by_tl == "0")
            <form method="POST" action="{{route('tl-acknowledge.store',['id' => $score->id])}}" id="acknowledgeScorecardForm">
                @csrf
            </form>
            @if(Auth::user()->thesignatures->count() > 0)
            <a class="btn btn-warning btn pull-right" onclick="acknowledgeScorecard()" href="#" title="Acknowledge Scorecard"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @else
            <a class="btn btn-warning btn pull-right" onclick="createSignature()" href="#" title="Please create signature"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @endif
            @elseif($score->acknowledge_by_agent == "0" && $score->acknowledge_by_tl == "0")
            <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
            @else
            <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
            @endif
            @elseif(Auth::user()->isManager())
            @if($score->acknowledge_by_tl == "1" && $score->acknowledge_by_manager == "0")
            <form method="POST" action="{{route('tl-acknowledge.store',['id' => $score->id])}}" id="acknowledgeScorecardForm">
                @csrf
            </form>
            @if(Auth::user()->thesignatures->count() > 0)
            <a class="btn btn-warning btn pull-right" onclick="acknowledgeScorecard()" href="#" title="Acknowledge Scorecard"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @else
            <a class="btn btn-warning btn pull-right" onclick="createSignature()" href="#" title="Please create signature"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @endif
            @elseif($score->acknowledge_by_agent == "0" || $score->acknowledge_by_tl == "0")
            <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
            @else
            <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
            @endif
            @elseif(Auth::user()->isTowerHead())
            @if($score->acknowledge_by_tl == "1" && $score->acknowledge_by_manager == "1" && $score->acknowledge_by_towerhead == "0")
            <form method="POST" action="{{route('tl-acknowledge.store',['id' => $score->id])}}" id="acknowledgeScorecardForm">
                @csrf
            </form>
            @if(Auth::user()->thesignatures->count() > 0)
            <a class="btn btn-warning btn pull-right" onclick="acknowledgeScorecard()" href="#" title="Acknowledge Scorecard"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @else
            <a class="btn btn-warning btn pull-right" onclick="createSignature()" href="#" title="Please create signature"><i class="mdi mdi-check-circle"></i> Acknowledge</a>
            @endif
            @elseif($score->acknowledge_by_tl == "0" || $score->acknowledge_by_manager == "0" )
            <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
            @else
            <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
            @endif
            @endif
        </div>
    </div>

    @include('notifications.success')
    @include('notifications.error')
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
                    <!-- <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$score->final_score}}%</span></td> -->
                    <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$final_score}}%</span></td>
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
                    <td>@if($score->thetl->thedepartment)
                        {{ucwords($score->thetl->thedepartment->department)}}
                        @endif
                    </td>
                    <td class="lbl-bold">Target:</td>
                    <td>{{$score->target}}%</td>
                </tr>
            </table>

        </div>
        <!--col-md-12-->
    </div>
    <!--row-->
    <br>
    <div class="row">
        <div class="col-md-12">

            <table width="100%" style="margin-top: 40px; font-size: 14px" cellspacing="5" cellpadding="5">
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
                            <85% reliability </td> <td class="ttxt-center lbl-bold">0%</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                    <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$final_score}}%</td>
                </tr>

            </table>

            <!-- <table width="100%" style="margin-top: 40px; font-size: 14px" cellspacing="5" cellpadding="5">
                <tr style="background: gray; text-align: center; font-weight: bold;">
                    <td>METRICS</td>
                    <td>WEIGHT</td>
                    <td>TARGET</td>
                    <td>PERFORMANCE RANGES</td>
                    <td></td>
                    <td>ACTUAL SCORE</td>
                    <td></td>
                    <td>FREQUENCY</td>
                    <td>SCORE</td>
                </tr>

                <tr>
                    <td style="width: 200px" class="lbl-bold ttxt-center">Team KPIs</td>
                    <td class="ttxt-center">40%</td>
                    <td class="ttxt-center"><span>LOB-Specific KPIs</span> </td>
                    <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">20%</span> - >= 95% Quality Team average <br>
                            <span style="font-weight: 500">10%</span> - 80% to 94% quality average <br>
                            <span style="font-weight: 500">0%</span> - < 80% quality average </span> </td> <td class="ttxt-center lbl-bold">{{$score->actual_quality}}%</td>
                    <td class="ttxt-center lbl-bold">Month to Date</td>
                    <td class="ttxt-center lbl-bold">40%</td>
                </tr>

                <tr>
                    <td style="width: 200px" class="lbl-bold ttxt-center">TL Deliverables</td>
                    <td class="ttxt-center">50%</td>
                    <td class="ttxt-center"><span>TL Specific action items</span> </td>
                    <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">15%</span> - >=100% Team Productivity<br>
                            <span style="font-weight: 500">5%</span> - 90% to 99% Team Productivity<br>
                            <span style="font-weight: 500">0%</span> - < 90% Team Productivity<br>
                        </span> </td>
                    <td class="ttxt-center lbl-bold">{{$score->productivity}}%</td>
                    <td class="ttxt-center lbl-bold">Month to Date</td>
                    <td class="ttxt-center lbl-bold">50%</td>
                </tr>

                <tr>
                    <td style="width: 200px" class="lbl-bold ttxt-center">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                    <td class="ttxt-center">10%</td>
                    <td class="ttxt-center"><span>95% Over-all Reliability</span> </td>
                    <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                            <span style="font-weight: 500">15%</span> - >=95% Reliability<br>
                            <span style="font-weight: 500">10%</span> - 90% to 95% Reliability<br>
                            <span style="font-weight: 500">5%</span> - 80% to 90% Reliability<br>
                            <span style="font-weight: 500">0%</span> - < 80% Reliability<br>
                        </span> </td>
                    <td class="ttxt-center lbl-bold">{{$score->actual_team_attendance}}%</td>
                    <td class="ttxt-center lbl-bold">Month to Date</td>
                    <td class="ttxt-center lbl-bold">10%</td>
                </tr>

                <tr>
                    <td colspan="4"></td>
                    <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$score->final_score}}%</td>
                    <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                    <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$score->final_score}}%</td>
                </tr>


            </table> -->
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
                    @if(\Auth::user()->id == $score->tl_id && empty($score->feedback) )
                    <td style="text-align: center">
                        <button class="btn btn-info text-center" style="margin: 10px" data-toggle="modal" data-target="#addFeedback">Add Feedback</button>
                    </td>
                    <!-- Modal -->
                    <div id="addFeedback" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #026B4D;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Add Feedback </h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('tl-feedback.store',['id' => $score->id])}}">
                                        @csrf
                                        <textarea name="feedback" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="return confirm('Are you sure you want to Submit this feedback?')" class="btn btn-info">Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    @elseif(\Auth::user()->id == $score->tl_id && !empty($score->feedback) && $score->acknowledge == 0)
                    <td>
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->feedback}}</textarea>
                        <button class="btn btn-info btn-info btn-sm" data-toggle="modal" data-target="#updateFeedback" style="margin-top: 10px"><i class="fa fa-pencil"></i> Edit Feedback</button>
                    </td>
                    <!-- Modal -->
                    <div id="updateFeedback" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #026B4D;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Update Feedback </h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('tl-feedback.store',['id' => $score->id])}}">
                                        @csrf
                                        <textarea name="feedback" class="form-control" id="" cols="30" rows="10">{{$score->feedback}}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="return confirm('Are you sure you want to update your feedback?')" class="btn btn-info">Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    @elseif(Auth::user()->isCBAOrTowerHead())
                    <td>
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->feedback}}</textarea>
                    </td>
                    @else
                    <td>
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->feedback}}</textarea>
                        <button class="btn btn-info btn-info btn-sm" data-toggle="modal" data-target="#updateFeedback" style="margin-top: 10px"><i class="fa fa-pencil"></i> Edit Feedback</button>
                    </td>
                    <!-- Modal -->
                    <div id="updateFeedback" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #026B4D;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Update Feedback </h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('tl-feedback.store',['id' => $score->id])}}">
                                        @csrf
                                        <textarea name="feedback" class="form-control" id="" cols="30" rows="10">{{$score->feedback}}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="return confirm('Are you sure you want to update your feedback?')" class="btn btn-info">Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </tr>


            </table>

        </div>
        <!--col-md-12-->
    </div>
    <!--row-->

    <!--ACTION PLAN -->
    <div class="row">
        <div class="col-md-12">

            <table width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                <tr>
                    <td colspan="4" style="background: gray; font-weight: bold">ACTION PLAN/S:</td>
                </tr>

                <tr>
                    @if(\Auth::user()->id == $score->tl_id && empty($score->action_plan) )
                    <td style="text-align: center">
                        <button class="btn btn-info text-center" style="margin: 10px" data-toggle="modal" data-target="#addActionPlan">Add Action Plan</button>
                    </td>
                    <!-- Modal -->
                    <div id="addActionPlan" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #026B4D;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Add Action Plan </h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('tl-action-plan.store',['id' => $score->id])}}">
                                        @csrf
                                        <textarea name="action_plan" class="form-control" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="return confirm('Are you sure you want to Submit this Action Plan?')" class="btn btn-info">Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    @elseif(Auth::user()->isCBAOrTowerHead())
                    <td>
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->action_plan}}</textarea>
                    </td>
                    @else
                    <td>
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->action_plan}}</textarea>
                        <button class="btn btn-info btn-info btn-sm" data-toggle="modal" data-target="#updateActionPlan" style="margin-top: 10px"><i class="fa fa-pencil"></i> Edit Action Plan</button>
                    </td>
                    <!-- Modal -->
                    <div id="updateActionPlan" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #026B4D;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Update Action Plan </h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('tl-action-plan.store',['id' => $score->id])}}">
                                        @csrf
                                        <textarea name="action_plan" class="form-control" id="" cols="30" rows="10">{{$score->action_plan}}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="return confirm('Are you sure you want to update your action plan?')" class="btn btn-info">Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </tr>


            </table>

        </div>
        <!--col-md-12-->
    </div>

    <!--SCREENSHOTS -->
    <div class="row">
        <div class="col-md-12">
            <table width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                <tr>
                    <td colspan="4" style="background: gray; font-weight: bold">SCREENSHOT/S:</td>
                </tr>
                <tr>
                    @if(Auth::user()->id == $score->tl_id && empty($score->screenshots) )
                    <td style="text-align: center">
                        <br>
                    </td>
                    @elseif(Auth::user()->id == $score->tl_id && !empty($score->screenshots))
                    <td>
                        <p>
                            @if($score->screenshots)
                            <?php $screenshots = str_replace('<img', '<img style="height: 100%; width: 100%; object-fit: contain; padding: 0 2px"', $score->screenshots); ?>
                            {!! $screenshots !!}
                            @endif
                        </p>
                    </td>
                    @elseif(Auth::user()->isCBAOrTowerHead())
                    <td>
                        @if($score->screenshots)
                        <p>
                            <?php $screenshots = str_replace('<img', '<img style="height: 100%; width: 100%; object-fit: contain; padding: 0 2px"', $score->screenshots); ?>
                            {!! $screenshots !!}
                        </p>
                        @else
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{!! $score->screenshots !!}</textarea>
                        @endif
                    </td>
                    @else
                    <td>
                        @if($score->screenshots)
                        <p>
                            <?php $screenshots = str_replace('<img', '<img style="height: 100%; width: 100%; object-fit: contain; padding: 0 2px"', $score->screenshots); ?>
                            {!! $screenshots !!}
                        </p>
                        @else
                        <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{!! $score->screenshots !!}</textarea>
                        @endif
                        <button class="btn btn-info btn-info btn-sm" data-toggle="modal" data-target="#updateScreenshots" style="margin-top: 10px"><i class="fa fa-pencil"></i> Edit Screenshot</button>
                    </td>
                    <!-- Modal -->
                    <div id="updateScreenshots" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #026B4D;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Update Screenshot </h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('tl-screenshots.store',['id' => $score->id])}}">
                                        @csrf
                                        {{-- <textarea name="screenshots" class="form-control" id="" cols="30" rows="10">{{$score->screenshots}}</textarea> --}}
                                        <textarea name="screenshots" id="screenshots" rows="8" class="form-control tinymce">{!! $score->screenshots !!}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" onclick="return confirm('Are you sure you want to update screenshot?')" class="btn btn-info">Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </tr>
            </table>
        </div>
        <!--col-md-12-->
    </div>
    <!--row-->
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
@endsection

@section('js')
<script src="{{asset('themes/assets/plugins/tinymce/js/tinymce/tinymce.min.js')}}?v=1"></script>
<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools wordcount",
            "textpattern noneditable help emoticons",
        ],

        height: 500,
        menubar: 'file edit view insert format tools table help',
        toolbar: "insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

        menubar: false,
        statusbar: false,
        // readonly : 1,

        image_title: true,
        image_description: false,
        paste_data_images: true,
        convert_urls: false,
        relative_urls: false,
        remove_script_host: false,
        block_unsupported_drop: true,

        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
            Note: In modern browsers input[type="file"] is functional without
            even adding it to the DOM, but that might not be the case in some older
            or quirky browsers like IE, so you might want to add it to the DOM
            just in case, and visually hide it. And do not forget do remove it
            once you do not need it anymore.
            */

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function() {
                    /*
                    Note: Now we need to register the blob in TinyMCEs image blob
                    registry. In the next release this part hopefully won't be
                    necessary, as we are looking to handle it internally.
                    */
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },

        images_upload_handler: function(blobinfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route("scorecard.image.upload") }}');
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                console.log(json);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobinfo.blob(), blobinfo.filename());
            xhr.send(formData);
        }
    });

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
            e.stopImmediatePropagation();
        }
    });
</script>
<script>
    function goBack() {
        window.history.back();
    }

    function printThis() {
        window.print();
    }

    function acknowledgeScorecard() {
        swal({
            title: "Acknowledge Scorecard?",
            text: "Note: Default Signature will be use to sign this scorecard.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FFC107",
            confirmButtonText: "Acknowledge",
            cancelButtonColor: "#d0211c",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
        }, function(isConfirm) {

            if (isConfirm) {
                swal("Thank You! ", '', "success");
                $("#acknowledgeScorecardForm").submit();
            }

        });
    }

    function createSignature() {
        swal({
            title: "Acknowledge Unsuccessful",
            text: "Note: You have no existing signature. You may create or upload signature in My Signatures tab!",
            type: "warning",
            confirmButtonColor: "#FFC107",
            confirmButtonText: "Ok",
            closeOnConfirm: true,
        });
    }
</script>
</script>

@endsection