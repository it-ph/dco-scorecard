@extends('layouts.dco-app')
@section('css')
<style>
        table {
            color: black;
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
@endsection
@section('content')
<div class="container-fluid">
        <div class="row noprint" style="margin-top: 20px;">
            <div class="col-md-12">
            <a href="{{url('scores/agent')}}">
            <button type="button" title="Click to go back to Lists" class="btn btn-success"><i class="fa fa-chevron-left"></i> Back to Lists</button>
            </a>


            <form method="GET" action="{{route('agent-score.print', ['id' => $score->id])}}">
                <button type="submit" title="Click to Print Scorecard"  style="margin-top: 10px; margin-right: 10px" class="btn btn-info btn-sm pull-left"><i class="fa fa-print"></i> Print</button>
            </form>
            @if(Auth::user()->isAdmin())
            <form method="GET" action="{{route('agent-score.edit', ['id' => $score->id])}}">
                    <button class="btn btn-primary btn-sm  pull-left" style="margin-top: 10px">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                </form>
            {{-- <a href="{{url('scores/agent/'.$score->id.'?from_show')}}"> <button class="btn btn-primary btn-sm  pull-left" style="margin-top: 10px">
                    <i class="fa fa-pencil"></i> Edit
                </button>
            </a> --}}
            @endif
{{-- 
            @if(Auth::user()->id == $score->agent_id && $score->acknowledge_by_agent == 0)
                <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                    @csrf
                    <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                </form>
            @elseif((Auth::user()->isSupervisor() || Auth::user()->isAdmin()) && ($score->acknowledge_by_agent == 1 && $score->acknowledge_by_tl == 0))
                <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                    @csrf
                    <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                </form>
            @elseif((Auth::user()->isManager() || Auth::user()->isAdmin()) && ($score->acknowledge_by_agent == 1 && $score->acknowledge_by_tl == 1 && $score->acknowledge_by_manager == 0))
                <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                    @csrf
                    <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                </form>
            @elseif(Auth::user()->isAdmin() && ($score->acknowledge_by_agent == "0" || $score->acknowledge_by_tl == "0" || $score->acknowledge_by_manager == "0"))
                <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;" title="Not yet Acknowledge by {{ucwords($score->theagent->name)}}"></i>
                <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
            @else
                <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;" title="This Scorecard was Acknowledge by {{ucwords($score->theagent->name)}}"></i>
                <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
            @endif --}}

            @if(Auth::user()->isAdmin())
                @if($score->acknowledge_by_agent == "0" || $score->acknowledge_by_tl == "0" || $score->acknowledge_by_manager == "0")
                    {{-- <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i> --}}
                    @if($score->acknowledge_by_agent == "1" && $score->acknowledge_by_tl == "0")
                        <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                            @csrf
                            <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                        </form>
                    @elseif($score->acknowledge_by_agent == "0" && $score->acknowledge_by_tl == "0")
                        <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
                    @else
                        <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
                    @endif
                @else
                    <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
                @endif

            @elseif(Auth::user()->isAgent())
                @if($score->acknowledge_by_agent == "0")
                    <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                        @csrf
                        <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                    </form>
                @else
                    <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
                @endif
            @elseif(Auth::user()->isSupervisor())
                @if($score->acknowledge_by_agent == "1" && $score->acknowledge_by_tl == "0")
                    <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                        @csrf
                        <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                    </form>
                @elseif($score->acknowledge_by_agent == "0" && $score->acknowledge_by_tl == "0")
                    <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;"></i>
                @else
                    <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;"></i>
                @endif
            @elseif(Auth::user()->isManager())
                @if($score->acknowledge_by_agent == "1" && $score->acknowledge_by_tl == "1" && $score->acknowledge_by_manager == "0")
                    <form method="POST" action="{{route('agent-acknowledge.store',['id' => $score->id])}}">
                        @csrf
                        <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                    </form>
                @elseif($score->acknowledge_by_agent == "0" || $score->acknowledge_by_tl == "0")
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
                        <td>@if($score->theagent->thedepartment)
                            {{ucwords($score->theagent->thedepartment->department)}}
                            @endif
                        </td>
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
                            <td class="ttxt-center">@if($quality) {{$quality->value}} @else {{ 0 }} @endif%</td>
                            <td class="ttxt-center"><span>95% <br>Quality <br>Monthly Average</span> </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <span style="font-weight: 500">40%</span> -  >= 95%  Quality average <br>
                                <span style="font-weight: 500">30%</span> -  85% to 94% quality average <br>
                                <span style="font-weight: 500">15%</span> -  80% to 84% quality average <br>
                                <span style="font-weight: 500">0%</span>  -  < 80% quality average </span> </td>
                            <td class="ttxt-center lbl-bold">{{$score->actual_quality}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score->quality}}%</td>
                        </tr>

                        <tr>
                            <td style="width: 200px" class="lbl-bold ttxt-center">PRODUCTIVITY</td>
                            <td class="ttxt-center">@if($productivity) {{$productivity->value}} @else {{ 0 }} @endif%</td>
                            <td class="ttxt-center"><span>90% <br>Productivity <br> Average</span> </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <span style="font-weight: 500">40%</span> - >=100% productivity average<br>
                                <span style="font-weight: 500">20%</span> - 90% to 99% productivity average<br>
                                <span style="font-weight: 500">10%</span> - 80% to 89% productivity average<br>
                                <span style="font-weight: 500">0%</span> - < 80% productivity average<br>
                                </span> </td>
                            <td class="ttxt-center lbl-bold">{{$score->actual_productivity}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score->productivity}}%</td>
                        </tr>


                        <tr>
                            <td style="width: 200px" class="lbl-bold ttxt-center">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                            <td class="ttxt-center">@if($reliability) {{$reliability->value}} @else {{ 0 }} @endif%</td>
                            <td class="ttxt-center"><span>95% <br>Over-all <br> Reliability</span> </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <span style="font-weight: 500">20%</span> - >=95% Reliability<br>
                                    <span style="font-weight: 500">15%</span> - 90% to 94% Reliability<br>
                                    <span style="font-weight: 500">10%</span> - 85% to 89% Reliability<br>
                                    <span style="font-weight: 500">5%</span> - 80% to 84% Reliability<br>
                                    <span style="font-weight: 500">0%</span> - < 80% Reliability<br>
                                </span> </td>
                            <td class="ttxt-center lbl-bold">{{$score->actual_reliability}}%</td>
                            <td class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
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
                                @if(\Auth::user()->id == $score->agent_id && empty($score->agent_feedback) )
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
                                                <form method="POST" action="{{route('agent-feedback.store',['id' => $score->id])}}">
                                                @csrf
                                                <textarea name="agent_feedback" class="form-control" id="" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" onclick="return confirm('Are you sure you want to Submit this feedback?')" class="btn btn-info">Save</button>
                                                </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                        </div>
                                    </div>

                                 @elseif(\Auth::user()->id == $score->agent_id && !empty($score->agent_feedback) && $score->acknowledge == 0)
                                    <td>
                                    <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->agent_feedback}}</textarea>
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
                                                <form method="POST" action="{{route('agent-feedback.store',['id' => $score->id])}}">
                                                @csrf
                                                <textarea name="agent_feedback" class="form-control" id="" cols="30" rows="10">{{$score->agent_feedback}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" onclick="return confirm('Are you sure you want to update your feedback?')" class="btn btn-info">Save</button>
                                                </form>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                        </div>
                                    </div>

                                @else
                                    <td>
                                    <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->agent_feedback}}</textarea>
                                    </td>
                                @endif
                            </tr>


                        </table>

                    </div><!--col-md-12-->
                </div><!--row-->

                <!--ACTION PLAN -->
                <div class="row">
                        <div class="col-md-12">

                                <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                                        <tr>
                                            <td colspan="4" style="background: gray; font-weight: bold">ACTION PLAN/S:</td>
                                        </tr>

                                        <tr>
                                            @if(Auth::user()->id == $score->agent_id && empty($score->action_plan) )
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
                                                            <form method="POST" action="{{route('agent-action-plan.store',['id' => $score->id])}}">
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

                                             @elseif(Auth::user()->id == $score->agent_id && !empty($score->action_plan) && $score->acknowledge == 0)
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
                                                            <form method="POST" action="{{route('agent-action-plan.store',['id' => $score->id])}}">
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

                                            @else
                                                <td>
                                                <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$score->action_plan}}</textarea>
                                                </td>
                                            @endif
                                        </tr>


                                    </table>

                        </div><!--col-md-12-->
                    </div><!--row-->

                    <div class="row" style="margin-top: 40px">
                        <div class="col-print-2"></div>
                        <div class="col-print-4 text-center">
                            <span style="font-weight: bold;">
                                @if($score->date_acknowledge_by_agent)
                                    <i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> {{ date('m/d/Y', strtotime($score->date_acknowledge_by_agent)) }}
                                @else
                                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                                @endif
                            </span>
                            <br> <span style="text-decoration: underline; font-weight: bold;">{{strtoupper($score->theagent->name)}}</span>
                            <br> <span style="font-weight: normal;font-size: 14px">Agent Name</span> </p>
                        </div><!--col-md-5-->

                        <div class="col-print-6 text-center">
                                <span style="text-decoration: underline; font-weight: bold;">{{strtoupper(date('m/d/Y'))}}</span>
                                <br> <span style="font-weight: normal;font-size: 14px">Date</span> </p>
                            </div><!--col-md-5-->
                    </div><!--row-->

                    <div class="row" style="margin-top: 20px">
                            <div class="col-print-2"></div>
                            <div class="col-print-4 text-center">
                                <span style="font-weight: bold;">
                                    @if($score->date_acknowledge_by_tl)
                                        <i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> {{ date('m/d/Y', strtotime($score->date_acknowledge_by_tl)) }}
                                    @else
                                        <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                                    @endif
                                </span>
                                <span style="text-decoration: underline; font-weight: bold;">
                                    @if($score->theagent->thesupervisor)
                                        <br> {{strtoupper($score->theagent->thesupervisor->name)}}
                                    @endif
                                </span>
                                <br> <span style="font-weight: normal;font-size: 14px">Supervisor</span> </p>
                            </div><!--col-md-5-->

                            <div class="col-print-6 text-center">
                                    <span style="font-weight: bold;">
                                        @if($score->date_acknowledge_by_manager)
                                            <i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> {{ date('m/d/Y', strtotime($score->date_acknowledge_by_manager)) }}
                                        @else
                                            <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                                        @endif
                                    </span>
                                    <span style="text-decoration: underline; font-weight: bold;">
                                            @if($score->theagent->themanager)
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
@endsection

@section('js')

<script>
        function goBack() {
            window.history.back();
        }

        function printThis(){
            window.print();
        }
    </script>

@endsection
