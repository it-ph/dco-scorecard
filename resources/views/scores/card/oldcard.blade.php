@inject('templateQueries', 'App\helpers\templateQueries')
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

    <div class="row">
        <div class="col-md-12">
                @include('notifications.success')
                @include('notifications.error')
        </div>
    </div>
        <div class="row noprint" style="margin-top: 20px;">
            <div class="col-md-12">
            <a href="{{url('v2/scores')}}/{{$role->id}}">
            <button type="button" title="Click to go back to Lists" class="btn btn-sm btn-success"><i class="fa fa-chevron-left"></i> Back to Lists</button>
            </a>
            

            <form method="GET" action="{{route('v2.score.print', ['scoreCardId' => $score->id,'roleId' => $role->id])}}">
                @csrf
                <button type="submit" title="Click to Print Scorecard"  style="margin-top: 10px; margin-right: 10px" class="btn btn-sm btn-info btn-sm pull-left"><i class="fa fa-print"></i> Print</button>
            </form>

            
            @if(\Auth::user()->id == $score->user_id && $score->is_acknowledge == 0) 

            <form method="POST" action="{{route('v2.score.acknowledge',['id' => $score->id])}}">
                    @csrf
                    <button type="submit" title="Click to Acknowledge This Scorecard" onclick="return confirm('Are you sure you want to Acknowledge this Score card?')" class="btn btn-warning btn-sm pull-right" style="margin-right: 10px"><i class="mdi mdi-check-circle"></i> Acknowledge</button>
                </form>
            @elseif($score->is_acknowledge == 0)
                <i class="fa fa-warning fa-2x pull-right" style="color: #dd4b39;" title="Not yet Acknowledge by {{ucwords($score->theuser->name)}}"></i>
            @else
                <i class="mdi mdi-check-circle fa-2x pull-right" style="color: #04b381;" title="This Scorecard was Acknowledge by {{ucwords($score->theuser->name)}}"></i>
                
            @endif
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
                        <td  style="padding-left: 10px">{{$score->month}}</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Department</td>
                        <td>@if($score->theuser->thedepartment)
                            {{ucwords($score->theuser->thedepartment->department)}}
                            @endif
                        </td>
                        <td class="lbl-bold">Target:</td>
                        <td style="padding-left: 10px">{{$score->target}}%</td>
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
 
                                
                                <?php  $tq = $templateQueries->scorecardContentBaseOnRowAndColumnPosition($score->id,$irow,$jcol); ?>
                                
                                <?php $tqCol = $templateQueries->scorecardContentBaseonColumn($score->id,$jcol); ?>
                                <?php $isSame = $templateQueries->duplicateChecker($score->id,$irow,$jcol); ?>
                     
                                @if($score->is_acknowledge == 1)
                                <td style="text-align: center ">{!! nl2br($tq->content) !!}%</td>
                                
                                @elseif($tqCol->is_fillable == 1)
                                 <td style="text-align: center">
                                    @if(Auth::user()->isAdmin())
                                        <div class="alert alert-success" id="success-fillable-{{$irow}}-{{$jcol}}" style="display:none"> <i class="fa fa-floppy-o"></i> Saved!
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                        </div>  
                                        <div class="alert alert-danger" id="danger-fillable-{{$irow}}-{{$jcol}}"  style="display:none"> <i class="fa fa-floppy-o"></i> There was an error! Please Try again.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                        </div> 

                                        {{-- <input type="text" class="form-control" id="content-fillable-{{$irow}}-{{$jcol}}" value="{{$tq->content}}"> <br> --}}
                                        <input type="text" onkeypress="javascript: if(event.keyCode == 13) updateScorecardFillable({{$score->id}},{{$irow}},{{$jcol}}); " class="form-control" id="content-fillable-{{$irow}}-{{$jcol}}" value="{{$tq->content}}"> <br>
                                        
                                        <input type="hidden" class="form-control" id="x_content-fillable-{{$irow}}-{{$jcol}}" value="{{$tq->content}}"> <br>
                                        
                                        <button onclick="updateScorecardFillable({{$score->id}},{{$irow}},{{$jcol}})" style="margin-top: 2px;" class="btn waves-effect waves-light btn-rounded btn-xs btn-info pull-right">save</button>
                                    @else
                                        <span style="font-weight: bold ;font-size: 16px;">{{$tq->content}}</span>
                                    @endif
                             
                                </td>

                                @elseif($isSame)
                                <TD></TD>
                                @else
                                <td style="text-align: center; border-right-style: none !important ">{!! nl2br($tq->content) !!}</td>
                                @endif
                                @endfor<!--jcol-->
                            </tr>
                            @endfor <!--irow-->
                       
                        @endif <!--if templatecontent_lastrow -->
                        
                    </table>
                </div><!--col-md-12-->
            </div><!--row-->



            @foreach($scorecard_remarks as $user_remarks)
            <div class="row">
                <div class="col-md-12">
                    <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                        <tr>
                        <td colspan="4" style="background: gray; font-weight: bold">{{strtoupper($user_remarks->name)}}</td>
                        </tr>
                        
                        <tr>
                            @if(\Auth::user()->id == $score->user_id && empty($user_remarks->user_update) ) 
                                <td style="text-align: center">
                                <button class="btn btn-info text-center" style="margin: 10px" data-toggle="modal" data-target="#addRemarks-{{$user_remarks->id}}">Add</button>
                                </td>
                            <!-- Modal -->
                            <div id="addRemarks-{{$user_remarks->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #026B4D;">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color: white">Add {{ucwords($user_remarks->name)}} </h4>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('v2.score.feedback',['id' => $score->id])}}">
                                            @csrf
                                            <textarea name="user_update" class="form-control" id="" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="submit" onclick="return confirm('Are you sure you want to Submit this feedback?')" class="btn btn-info">Save</button>
                                            </form>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                
                                    </div>
                                </div>

                             @elseif(\Auth::user()->id == $score->user_id && !empty($user_remarks->user_update) && $score->is_acknowledge == 0) 
                                <td>
                                <textarea name="" id="" readonly cols="30" rows="10" class="form-control" style="color: black;">{{$user_remarks->user_update}}</textarea>
                                <button class="btn btn-info btn-info btn-sm" data-toggle="modal" data-target="#updateRemarks-{{$user_remarks->id}}" style="margin-top: 10px"><i class="fa fa-pencil"></i> Edit Feedback</button>
                            </td> 
                            <!-- Modal -->
                            <div id="updateRemarks-{{$user_remarks->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: #026B4D;">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color: white">Update your feedback for {{strtoupper($user_remarks->name)}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('v2.score.feedback',['id' => $user_remarks->id])}}">
                                            @csrf
                                            <textarea name="user_update" class="form-control" id="" cols="30" rows="10">{{$user_remarks->user_update}}</textarea>
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
            @endforeach

            <div class="row">
                    <div class="col-md-12">
                        <table  width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                            <tr>
                                <td colspan="4" style="background: gray; font-weight: bold">EMPLOYEE FEEDBACK:</td>
                            </tr>
                            
                            <tr>
                                @if(\Auth::user()->id == $score->user_id && empty($score->agent_feedback) ) 
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
                                                <form method="POST" action="{{route('v2.score.feedback',['id' => $score->id])}}">
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

                                 @elseif(\Auth::user()->id == $score->user_id && !empty($score->agent_feedback) && $score->is_acknowledge == 0) 
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
                                                <form method="POST" action="{{route('v2.score.feedback',['id' => $score->id])}}">
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
                                            @if(\Auth::user()->id == $score->user_id && empty($score->action_plan) ) 
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
                                                            <form method="POST" action="{{route('v2.score.actionplan',['id' => $score->id])}}">
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
            
                                             @elseif(\Auth::user()->id == $score->user_id && !empty($score->action_plan) && $score->is_acknowledge == 0) 
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
                                                            <form method="POST" action="{{route('v2.score.actionplan',['id' => $score->id])}}">
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
                            <br> <span style="font-weight: normal;font-size: 14px">Employee Name</span> </p>
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
@endsection

@section('js')

<script>
        function goBack() {
            window.history.back();
        }
    
        function printThis(){
            window.print();
        }

        function updateScorecardFillable(scorecardId,row,col){
            var cntn = $("#content-fillable-"+row+"-"+col).val();
            var x_cntn = $("#x_content-fillable-"+row+"-"+col).val();
            if(cntn == ""){
                event.preventDefault();
                alert("Please input a Numerical value!");
            }else if(isNaN(cntn)){
                alert("Please input a Numerical value!");
            }else{
                event.preventDefault();
                
                var finalScoreNow = $("#finalScoreId").text();
                console.log(finalScoreNow);

                //check if previous is empty
                if(x_cntn == "")
                {
                    finalScore = parseFloat(finalScoreNow) + parseFloat(cntn);
                }else{
                    finalScore_1 = parseFloat(finalScoreNow) - parseFloat(x_cntn);
                    finalScore = finalScore_1 + parseFloat(cntn);
                }

             
                $.ajax({
                
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{url('v2/scores/update-scorecard-fillable')}}",
                    data: {content : cntn,scoreCardId : scorecardId,row_position:row,column_position:col,finalScore : finalScore},
                    success: function(response)
                    {    
                        if(response)
                        {
                            $("#success-fillable-"+row+"-"+col).fadeToggle();
                            $("#x_content-fillable-"+row+"-"+col).val(cntn);
                            $("#finalScoreId").text(finalScore);
                            console.log(response); 
    
                        }else{
                            $("#danger-fillable-"+row+"-"+col).fadeToggle();
                            console.log("ERROR :" + response); 
                        }
                    
                    }
                });

            }// endif not empty
           
          
       
        }
        
</script>




@endsection