<?php use carbon\carbon;
$dt = carbon::now();
$dt1 = carbon::now();
?>
@extends('layouts.dco-app')

@section('content')
<h3><strong>Editing Scorecard of : {{strtoupper($score->theagent->name)}}</strong></h3>
<hr>

<div class="row" style="background: white; padding: 10px;">
    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')

        <a href="{{url('scores/agent')}}">
            <button class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> Back to Lists</button>
        </a>
    </div>
    
    <div class="col-md-1"></div>
    <div class="col-md-6">
        <form method="POST" action="{{route('agent-score.update',['id' => $score->id])}}">
        @csrf
        @method('PUT')
               
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="month">Month <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="month" id="month" class="form-control">
                                <option selected value="{{$score->month}}">{{$score->month}}</option>
                                <option value="{{$dt->addMonth()->format('M Y') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}" >{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                            </select>
                            @error('month')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="target">Target % <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <input type="text" required name="target" value="{{$score->target}}" class="form-control" id="target">
                    </div>
                </div>

                <div class="col-md-3">
                        <h4><strong> FINAL SCORE : <br><span style="font-size: 26px; text-align: center; font-weight: bold; margin-left: 20px;margin-top: 100px" id="totalScoreLbl">{{$score->final_score}}% </span></strong></h4>
                         <input type="hidden" value="{{$score->final_score}}" name="final_score" id="final_score">
                        
                </div>

            </div><!--row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="role">Agents <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="agent_id" required id="agent_id" class="form-control">
                                <option value="{{$score->agent_id}}">{{strtoupper($score->theagent->name)}}</option>
                                    @foreach ($agents as $key => $val)
                                    @if (old('agent_id') == $val->name)
                                    <option value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                                    @else
                                        <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                                    @endif
                                    @endforeach
                                    </select>
                                
                                @error('agent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                        </div>
                    </div>
                </div><!--row-->
            <div class="row">
                
                <div class="col-md-12">
                    <table class="display nowrap table table-bordered dataTable">
                            <tr style="background: #026B4D; color: white">
                                    <td>Metrics</td>
                                    <td>Actual Score</td>
                                    <td>Score</td>
                                </tr>
                        <tr>
                            <td><span style="font-weight: bold"> QUALITY (OVER-ALL) <small>40%</small></span>   </td>
                            <td><input id="actual_quality" required name="actual_quality" value="{{$score->actual_quality}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="quality" required name="quality" value="{{$score->quality}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold"> PRODUCTIVITY <small>40%</small></span>   </td>
                            <td><input id="actual_productivity" required name="actual_productivity" value="{{$score->actual_productivity}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="productivity" required name="productivity" value="{{$score->productivity}}" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                            
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold"> RELIABILITY <small>20%</small><br>
                                    <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span>   </td>
                            <td><input id="actual_reliability" required name="actual_reliability" value="{{$score->actual_reliability}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="reliability" required name="reliability" value="{{$score->reliability}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                    </table>
                </div>

            </div><!--row-->
             

            <hr>
                <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to add this Score?')"><i class="mdi mdi-content-save"></i> Save</button>
            </form>

           
</div>
</div>      
                


@endsection

@section('js')
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
        </script>
@endsection
