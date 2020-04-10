@extends('layouts.dco-app')

@section('content')

<div class="row">
    <div class="col-md-7">
            <h3> Hello, <strong>{{strtoupper(Auth::user()->name)}}!</strong></h3> 
    </div><!--div 5 -->

    <div class="col-md-5">

            <div class="card">
                    <div class="card-header" style="background: #06d79c">
                        <h4 class="m-b-0 text-white"> @if($last_score_card_score){{$last_score_card_score->month}}  @endif </h4></div>
                    <div class="card-body" style="text-align: center">
                        <h3 class="card-title"> Score  </h3>
                    @if($last_score_card_score)
                        <h2 style="font-weight: bold; font-family: arial; font-size: 30px; margin-bottom: 10px">{{$last_score_card_score->final_score}}% 
                        @if($last_score_card_score->is_acknowledge==0)<i class="fa fa-warning" title="You have NOT yet acknowledge this Scorecard" style="color: #ffb22b;font-size: 18px;"></i>
                        @else <i class="fa fa-check-circle" title="You acknowledge this Scorecard" style="color: #026c4e;font-size: 18px;"></i>
                        @endif
                        </h2>
                    @endif
                        <hr>
                    @if($last_score_card_score)
                    <a href="{{url('/v2/scores/show/')}}/{{$last_score_card_score->id}}/{{Auth::user()->role_id}}" class="btn btn-inverse btn-sm pull-right">View card</a>
                   @endif
                    </div>
                </div>

                
    </div><!--div 5 -->
</div><!--row-->

<div class="row  m-t-10" >
        <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-b-10">
                            <div class="col-md-1">
                                    <label for="">Year : </label> 
                            </div>
                            <div class="col-md-2">
                                <form action="" method="GET">
                                @csrf
                                <select name="search_year" onchange="this.form.submit()" class="form-control" id="search_year">
                                    <option value=""></option>
                                    @foreach($avail_year_in_scorecard as $year)
                                    <option>{{$year->year}}</option>
                                    @endforeach
                                </select>
                                         
                                </form>
                            </div>

                        </div><!--row mb5-->
                       
                        <h4 class="card-title">Monthly Scorecard</h4>
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
    color: ["#009efb", "#009efb"],
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data :  [ @foreach($scores as $score)
"{{substr($score->month, 0,3)}}",
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
            name:'Year {{$selected_year}}',
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