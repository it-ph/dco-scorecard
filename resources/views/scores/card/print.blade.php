@inject('templateQueries', 'App\helpers\templateQueries')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div class="container-fluid">
        <div class="row noprint" style="margin-top: 20px;">
            <div class="col-md-12">
            <a href="{{url('v2/scores/show')}}/{{$score->id}}/{{$role->id}}"><button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> Back to Lists</button></a>
            <button type="button" title="Click to Print Scorecard" class="btn btn-info bt-sm pull-right" onclick="printThis()"><i class="fa fa-print"></i> Print</button>
        </div>
        </div>


        <div class="row" style="margin-top: 40px;">
         
            <div class="col-md-12">
                <table  width="100%"  cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; text-align: center; font-weight: bold;font-size: 22px">@if($score->theuser->thedepartment)
                            {{strtoupper($role->role) }}
                            @endif - SCORECARD</td>
                    </tr>
                    
                    <tr>
                        <td class="lbl-bold">Employee Name:</td>
                        <td>{{ucwords($score->theuser->name)}}</td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 18px;"> FINAL SCORE :</span> </td>
                        <td rowspan="2" style="text-align: center;font-weight: bold; font-size: 18px;"><span id="finalScoreId"> {{$score->final_score}}</span> <span>%</span>
                            {{-- <input type="text" class="form-control" id="scorecardFinalScore-{{$score->id}}" value="{{$score->final_score}}" placeholder="%"><br>
                            <button onclick="updateScorecardFinalScore({{$score->id}})" style="margin-top: 5px;" class="btn waves-effect waves-light btn-rounded btn-xs btn-info pull-right">save</button> --}}
                        </td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Emp ID:</td>
                        <td>{{$score->theuser->emp_id}}</td>
                      
                    </tr>

                    <tr>
                        <td class="lbl-bold">Position</td>
                        <td>{{ucwords($score->theuser->theposition->position)}}</td>
                        <td class="lbl-bold">Month:</td>
                        <td>{{$score->month}}</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Department</td>
                        <td>@if($score->theuser->thedepartment)
                            {{ucwords($score->theuser->thedepartment->department)}}
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

                            @foreach($scorecard_column as $columns)
                            <td>{{strtoupper($columns->column_name)}}</td>

                            @endforeach
                            {{-- <td>METRICS</td>
                            <td>WEIGHT</td>
                            <td>TARGET</td>
                            <td>PERFORMANCE RANGES</td>
                            <td>ACTUAL SCORE</td>
                            <td>SCORE</td> --}}
                        </tr>

                        @if($templatecontent_lastrow)
                        <?php $lastrow = $templatecontent_lastrow->row_position; ?>
                        <?php $row = $templatecontent_lastrow->row_position + 1; ?>
                                  {{-- ANG COLUMN AYz : {{count($scorecard_column) - 1}} <!--add start with 0--> --}}
                                {{-- ANG LAST ROW  AY : {{$lastrow}} <!--add start with 0--> --}}
                            @for ($irow = 0; $irow <= $lastrow; $irow++)
                            <tr>
                                @for ($jcol = 0; $jcol+1 <= count($scorecard_column) ; $jcol++) <!--column -->
                                <?php $tq = $templateQueries->scorecardContentBaseOnRowAndColumnPosition($score->id,$irow,$jcol); ?>
                                <?php  $tqCol = $templateQueries->scorecardContentBaseonColumn($score->id,$jcol); ?>
                                <?php $isSame = $templateQueries->duplicateChecker($score->id,$irow,$jcol); ?>
                                <td style="text-align: center">
                                @if($tqCol->is_fillable == 1)
                                    {!! nl2br($tq->content) !!}
                                @elseif($isSame)  
                                
                                @else
                                    {!! nl2br($tq->content) !!}
                                @endif
                                </td>
                                @endfor<!--jcol-->
                            </tr>
                            @endfor <!--irow-->
                       
                        @endif <!--if templatecontent_lastrow -->
                        
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
                                            @if(\Auth::user()->id == $score->agent_id && empty($score->action_plan) ) 
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
            
                                             @elseif(\Auth::user()->id == $score->agent_id && !empty($score->action_plan) && $score->acknowledge == 0) 
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

                    <div class="row" style="margin-top: 20px">
                        <div class="col-print-2"></div>
                        <div class="col-print-4 text-center">
                            <span style="text-decoration: underline; font-weight: bold;">{{strtoupper($score->theuser->name)}}</span>
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
                                <span style="text-decoration: underline; font-weight: bold;">
                                    @if($score->theuser->thesupervisor)
                                    {{strtoupper($score->theuser->thesupervisor->name)}}
                                    @endif
                            </span>
                                <br> <span style="font-weight: normal;font-size: 14px">Supervisor</span> </p>
                            </div><!--col-md-5-->
    
                            <div class="col-print-6 text-center">
                                    <span style="text-decoration: underline; font-weight: bold;">
                                            @if($score->theuser->themanager)
                                            {{strtoupper($score->theuser->themanager->name)}}
                                            @endif
                                    </span>
                                    <br> <span style="font-weight: normal;font-size: 14px">Operations Manager</span> </p>
                                </div><!--col-md-5-->
                    </div><!--row-->
                    <div class="row" style="margin-top: 20px">
                            <div class="col-print-1"></div>
                            <div class="col-print-11 text-center">
                                    <span style="text-decoration: underline; font-weight: bold;">
                                         {{strtoupper($towerhead->value)}}
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
