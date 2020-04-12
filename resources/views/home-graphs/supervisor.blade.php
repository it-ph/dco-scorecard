<div class="col-md-4">
        <h3> Hello, <strong>{{strtoupper(Auth::user()->name)}}!</strong></h3> 
</div><!--div 5 -->

<div class="col-md-4">
    <div class="card">
            <div class="card-header" style="background: #06d79c">
                <h4 class="m-b-0 text-white"> @if($last_score_card_score) <i class="mdi mdi-book-open"></i> Your Recent card @endif </h4></div>
            <div class="card-body" style="text-align: center">
                <h3 class="card-title"> Score :  {{$last_score_card_score->month}}  </h3>
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
             
</div><!--div 4 -->
 <div class="col-md-4">
    <div class="card">
            <div class="card-header" style="background: #20787b">
                <h4 class="m-b-0 text-white"> Team Un-Acknowledge card: <span style="font-weight: bold; font-size: 25px;"></span>  </h4></div>
            <div class="card-body" style="text-align: center">
                <h3 class="card-title"> Count  </h3>
            <h2 style="font-weight: bold; font-family: arial; font-size: 40px; margin-bottom: 10px">
                        {{count($unAcknowledge_list)}}
                </h2>
                <hr>
             </div>
        </div>

            
</div><!--div 4 -->