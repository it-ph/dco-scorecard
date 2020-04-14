@inject('ScoreCardHelper', 'App\helpers\ScoreCardHelper')
@extends('layouts.dco-app')

@section('content')
<div class="row">
        <div class="col-md-12">
                @include('notifications.success')
                @include('notifications.error')
        </div>
    </div>
<div class="row">

        @if(Auth::user()->isAdmin() || Auth::user()->isManager()) 
            @include('home-graphs.admin')
        @elseif(Auth::user()->isSupervisor())
            @include('home-graphs.supervisor')
        @else
            @include('home-graphs.user')
        @endif
        
</div><!--row-->


<div class="row  m-t-10" >
        <div class="col-lg-12">
                <div class="card" style="border-top: 2px solid #ffb22b;">
                    <div class="card-body">
                        <div class="row m-b-10">
                           
                          
                                
                                <form action="" method="GET">
                                @csrf
                                <div class="col-md-12" style="margin-top: 5px">
                                        <div class="row">

                                @if(Auth::user()->isAdmin() || Auth::user()->isManager() || Auth::user()->isSupervisor()) 
                                
                                    <div class="col-md-5">
                                        <label for="">Name</label>
                                            <select name="user_id"  class="form-control" id="user_id">
                                            @if(\Request::has('user_id')) 
                                                <?php $theUser = $ScoreCardHelper->whosTheUser(\Request()->user_id); ?>
                                                @if($theUser) 
                                                    <option value="{{$theUser->id}}">{{strtoupper($theUser->name)}}</option>    
                                                   @endif
                                            @else
                                            <option value=""></option>
                                            @endif

                                            @if(Auth::user()->isSupervisor())
                                            <option value="{{\Auth::user()->id}}">{{strtoupper(\Auth::user()->name)}}</option>
                                            @endif
                                            @foreach($avail_users_in_score as $scorecard_users)
                                            <option value="{{$scorecard_users->theuser->id}}">{{strtoupper($scorecard_users->theuser->name)}}</option>
                                            @endforeach
                                                </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="">Year </label>
                                        <select name="search_year" class="form-control" id="search_year">
                                            @if($selected_year)<option>{{$selected_year}}</option> @else<option>{{date('Y')}}</option>@endif
                                                @foreach($avail_year_in_scorecard as $year)
                                            <option>{{$year->year}}</option>
                                             @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">&nbsp;</label>
                                        <button type="submit" class="btn btn-info">GO</button>
                                    </div>
                                    

                                @else
                                    <div class="col-md-4">
                                        <label for="">Year: </label> 
                                    </div>

                                <div class="col-md-8">
                                    <select name="search_year" onchange="this.form.submit()" class="form-control" id="search_year">
                                    @if($selected_year)<option>{{$selected_year}}</option> @else<option>{{date('Y')}}</option>@endif
                                            
                                        @foreach($avail_year_in_scorecard as $year)
                                        <option>{{$year->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                          
                                @endif
                                        
                            </div><!--row-->
                                    
                               
                        </div><!--md 12-->
                                </form>
                           

                        </div><!--row mb5-->
                       
                        <h4 class="card-title">Monthly Scorecard 
                            @if(Auth::user()->isAdmin() || Auth::user()->isManager() || Auth::user()->isSupervisor()) 
                                @if(\Request::has('user_id')) 
                                 for :  @if($theUser) {{strtoupper($theUser->name)}}@endif
                                @endif
                          
                            @endif
                                
                        </h4>
                        <div id="bar-chart" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
</div><!--row-->
@endsection

@section('js')
<script src="{{asset('js/addons/echarts-all.js')}}"></script>
<script>
// ============================================================== 
// Bar chart option
// ============================================================== 
var myChart = echarts.init(document.getElementById('bar-chart'));

// specify chart configuration item and data
option = {
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        // data:['Site A','Site B']
        data:['Year {{$selected_year}}']
    },
    toolbox: {
        show : true,
        feature : {
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    color: ["#55ce63", "#009efb"],
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data :  [ @foreach($scores as $score)
"{{substr($score->month, 0,3)}} {{$selected_year}}",
            @endforeach ]
            // data : ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : [
        {
            name:'Final Score',
            type:'bar',
            // data:[80, 90, 60, 90, 80, 95, 85, 95, 88, 90, 85, 95],
            data :  [ @foreach($scores as $score)
"{{$score->final_score}}",
            @endforeach ],
            markPoint : {
                data : [
                    {type : 'max', name: 'Max'},
                    {type : 'min', name: 'Min'}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name: 'Average'}
                ]
            }
        }, {
            name:'Target',
            type:'bar',
            // data:[80, 90, 60, 90, 80, 95, 85, 95, 88, 90, 85, 95],
            data :  [ @foreach($scores as $score)
"{{$score->target}}",
            @endforeach ],
            
        },

    ]
};
                    

// use configuration item and data specified to show chart
myChart.setOption(option, true), $(function() {
            function resize() {
                setTimeout(function() {
                    myChart.resize()
                }, 100)
            }
            $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
        });

        </script>
@endsection