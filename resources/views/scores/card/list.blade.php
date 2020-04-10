@inject('templateQueries', 'App\helpers\templateQueries')
<?php use carbon\carbon;
$dt = carbon::now();
$dt1 = carbon::now();
?>
@extends('layouts.dco-app')
@section('css')
<style>
#scorecard_datatable{
    font-size: 14px !important;
}
th{
    text-align: center;
}
</style>
@endsection

@section('content')

@if(Auth::user()->isAdmin() || Auth::user()->isManager() || Auth::user()->isSupervisor()) 
<h3><strong>{{strtoupper($role->role)}} SCORECARD</strong> </h3>
@else
<div class="m-t-10"></div>
@endif


<div class="row" id="filterByMonth" style="display: none">
    <div class="col-md-offset-8 col-md-4">
        <div class="form-group">
            <label for="target">Filter by Month: </label>
            <form action="" method="GET" name="myform" id="myform"> 

            <select name="filter_month" required id="filter_month" class="form-control">
                    <option></option>
                    @foreach ($avail_months as $avail_month)
                        <option value="{{$avail_month->month}}">{{$avail_month->month}}</option>
                    @endforeach
                    </select>
                
                @error('filter_month')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
                <button type="submit" class="btn btn-success bt-sm pull-right" style="margin-top: 10px">Go <i class="fa fa-chevron-circle-right"></i></button>
            </form>
        </div>
    </div>
</div>

<div class="row" style="margin-bottom: 10px">
    <div class="col-md-11">

            <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filters
                    </button>
                    <div class="dropdown-menu animated flipInY" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="#" onclick="toggleMonthFilter()">By Month</a>

                        @if(agentHasUnAcknowledgeCard() > 0 && \Auth::user()->isAgent())
                        <a class="dropdown-item" style="background: #e81f37; color: white" href="{{url('scores/agent')}}?not_acknowledge">View Un Acknowledge Scorecards <span style="font-style: italic; font-size: 12px">({{agentHasUnAcknowledgeCard()}})</span></a>
                        @else 
                        <a class="dropdown-item" href="{{url('scores/agent')}}?not_acknowledge">View Un Acknowledge Scorecards</a>
                       
                        @endif
                        <a class="dropdown-item" href="{{url('scores/agent')}}?acknowledge">View Acknowledge Scorecards</a>
                        <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{url('v2/scores')}}/{{$role->id}}?view_all">View All Scorecards</a>
                        
                    </div>
                </div>

        {{-- <a href="{{url('scores/agent')}}?view_all">
        <button title="Click to Filter Month" class="btn btn-sm btn-success waves-effect waves-light" type="button"><span class="btn-label"> <i class="mdi mdi-refresh"></i> </span>View All </button>
        </a>     --}}
        {{-- <button onclick="toggleMonthFilter()" title="Click to Filter Month" class="btn btn-sm btn-primary waves-effect waves-light" type="button"><span class="btn-label"> <i class="fa fa-search"></i> </span>Month </button> --}}
    </div>
    @if(\Auth::user()->isAdmin()) 
    <div class="col-md-1">
        <button title="Create Scorcard" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#addAgentScore" type="button"><span class="btn-label"> <i class="mdi mdi-account-plus"></i> </span>Add </button>
    </div>
    @endif
</div>
<div class="row">
 
    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')
        <div class="card">
            <div class="card-body">
            <div class="table-responsive">
            <table id="scorecard_datatable" class="display nowrap table table-hover table-bordered dataTable " cellspacing="0" width="100%">            
                <thead  style="background: #04b381; color: white; font-weight: bold">
                    <tr>
                        <th>Month</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        @if(Auth::user()->isSupervisor())
                        <th>Manager</th>
                        @elseif(Auth::user()->isManager())

                        @else
                        <th>Supervisor</th>
                        <th>Manager</th>
                        @endif
                        <th>Final Score</th>
                        <th ></th>
                        @if(Auth::user()->isAdmin()) 
                        <th ></th> 
                         @endif
                    </tr>
                </thead>
                <tbody> @foreach($scores as $score)
                    <tr>
                    <td class="table-dark-border" style="width: 150px; text-align: center">
                        @if($score->is_acknowledge == 0)
                        <i class="fa fa-warning" style="color: #dd4b39; font-size: 16px" title="Not yet Acknowledge by {{ucwords($score->theuser->name)}}"></i>
                        @else
                        <i class="mdi mdi-check-circle" style="color: #04b381; font-size: 16px" title="This Scorecard was Acknowledged by {{ucwords($score->theuser->name)}}"></i>
                        @endif 
                        <a href="{{url('scores/agent/show/' . $score->id)  }}" style="color: black;" title="Click to view Scorecard">
                        {{$score->month}} </a>
                    </td>
                    <td class="table-dark-border" style="width: 150px; text-align: center">{{$score->theuser->emp_id}}</td>
                    <td class="table-dark-border">{{ucwords($score->theuser->name)}}</td>
                    <td class="table-dark-border">
                        @if($score->theuser->thedepartment)
                        {{ucwords($score->theuser->thedepartment->department)}}
                        @endif
                    </td>

                    @if(Auth::user()->isSupervisor())
                        <td class="table-dark-border">
                            @if($score->theuser->themanager)
                            {{ucwords($score->theuser->themanager->name)}}
                            @endif
                        </td>
                    @elseif(Auth::user()->isManager())

                    @else
                        <td class="table-dark-border">
                            @if($score->theuser->thesupervisor)
                            {{ucwords($score->theuser->thesupervisor->name)}}
                            @endif
                        </td>
    
                        <td class="table-dark-border">
                            @if($score->theuser->themanager)
                            {{ucwords($score->theuser->themanager->name)}}
                            @endif
                        </td>
                    @endif

                   
                    {{-- <td class="table-dark-border" style="width: 150px; text-align: center">{{$score->quality}}</td>
                    <td class="table-dark-border" style="width: 150px; text-align: center">{{$score->productivity}}</td>
                    <td class="table-dark-border" style="width: 150px; text-align: center">{{$score->reliability}}</td> --}}
                    <td class="table-dark-border" style="width: 150px; text-align: center">{{$score->final_score}}%</td>
                               
                   <td class="table-dark-border" style="width: 150px; text-align: center">
                        <form method="GET" action="{{route('v2.score.show', ['scoreCardId' => $score->id,'roleId' => $role->id])}}">
                        <button type="submit" class="btn btn-sm btn-warning">View Scorecard</button>
                        </form>
                    </td> 

                    @if(Auth::user()->isAdmin())
                    <td class="table-dark-border" style="width: 150px; text-align: center">
                        <form method="POST" action="{{route('v2.score.destroy', ['id' => $score->id])}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this score?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                        </form>
                            {{-- <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu animated flipInY" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    
                                    <span class="dropdown-item text-center">
                                         <form method="GET" action="{{route('agent-score.edit', ['id' => $score->id])}}">
                                                <button class="btn btn-sm btn-primary text-center">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </button>
                                            </form>
                                    </span>

                                   <span class="dropdown-item text-center">
                                    <form method="POST" action="{{route('agent-score.destroy', ['id' => $score->id])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this score?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</button>
                                    </form>
                                    </span>
                                </div>
                            </div><!--btn-group--> --}}
                    </td>
                     @endif
          
                    </tr>

                    {{-- @include('scores.agents.edit_modal') --}}
                    @endforeach
                 
                </tbody>
            </table>
        </div><!--table-responsive-->
            
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-md-12-->
</div><!--row-->

@endsection

    @if(\Auth::user()->isAdmin()) 
        @include('scores.card.add_modal')
    @endif

@section('js')
@include('js_addons')



<script>

    function updateTemplateId()
    {
        $("#template_name").val($("#template_id option:selected").text()) 
    }
    function userSelected(){
        $(".selectedUser").text($("#select-value-user option:selected").text())
    }

    function createTemplate(){
        $("#buildButton").fadeToggle();
        $("#buildLoading").fadeToggle();
    }
</script>

<script>
        $(document).ready(function() {
         var table = $('#scorecard_datatable').DataTable( {
            // @if(\Auth::user()->isAdmin()) "pageLength": 25, @endif
            "pagingType": "full_numbers",
            "order": [ 2, "asc" ],
              orderCellsTop: true,
              fixedHeader: true,
              dom: 'Bfrtip',
              buttons: [
            {
                extend: 'excel',
               exportOptions: {
                columns: [0,1,2,4]
                }
            }
            
        ]
                 
      
      
          } );
      } );
</script>

<script>
function sumTotalScore()
{
    var quality = $("#quality").val();
    var productivity = $("#productivity").val();
    var reliability = $("#reliability").val();

    quality = isNaN(quality) ? 0 : quality;
    productivity = isNaN(productivity) ? 0 : productivity;
    reliability = isNaN(reliability) ? 0 : reliability;

    var totalScore = parseInt(quality) + parseInt(productivity) + parseInt(reliability);
    $("#totalScoreLbl").html(totalScore + "%");
    $("#final_score").val(totalScore)
    console.log(totalScore);
}


function toggleMonthFilter()
{
    $("#filterByMonth").slideToggle();
}


</script>
@endsection