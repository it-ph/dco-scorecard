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
    <div class="col-md-9">
        <form method="POST" action="{{route('agent-score.update',['id' => $score->id])}}">
        @csrf
        @method('PUT')

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="month_type">Month Type <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <input type="hidden" value="{{$score->month_type}}" name="month_type">
                            <select name="mt" id="mt" class="form-control" disabled>
                                <option value=""></option>
                                <option value="mid" @if($score->month_type == 'mid') selected @endif>mid</option>
                                <option value="end" @if($score->month_type == 'end') selected @endif>end</option>
                            </select>
                            @error('mt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>

                <div class="col-md-3">
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

                <div class="col-md-3">
                    {{-- <div class="form-group">
                        <label for="target">Target % <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <input type="text" required name="target" value="{{$score->target}}" class="form-control" id="target">
                    </div> --}}
                    <h4> Target : </h4>
                        <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                            <span style="font-size: 20px; text-align: center;" id="targetlbl">@if($target) {{$target->value}} @else {{ 0 }} @endif% </span>
                            <input type="hidden" name="target" id="target" value="@if($target) {{$target->value}} @else {{ 0 }} @endif">
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
                                    <td>Weightage</td>
                                </tr>
                        <tr>
                            <td><span style="font-weight: bold"> QUALITY (OVER-ALL) <small>@if($quality) {{$quality->value}} @else {{ 0 }} @endif%</small></span>   </td>
                            <td><input id="actual_quality" required name="actual_quality" value="{{$score->actual_quality}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="q" value="@if($quality) {{$quality->value}} @else {{ 0 }} @endif" type="hidden" class="form-control" placeholder="%">
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    {{-- <input id="quality" required name="quality" value="{{$score->quality}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="quality">{{$score->quality}} </span>
                                    <input type="hidden" name="quality" id="q_val" value="{{$score->quality}}">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold"> PRODUCTIVITY <small>@if($productivity) {{$productivity->value}} @else {{ 0 }} @endif%</small></span>   </td>
                            <td><input id="actual_productivity" required name="actual_productivity" value="{{$score->actual_productivity}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="p" value="@if($productivity) {{$productivity->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    {{-- <input id="productivity" required name="productivity" value="{{$score->productivity}}" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="productivity">{{$score->productivity}} </span>
                                    <input type="hidden" name="productivity" id="p_val" value="{{$score->productivity}}">
                                </div>
                            </td>

                        </tr>

                        <tr>
                            <td><span style="font-weight: bold"> RELIABILITY <small>@if($reliability) {{$reliability->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span>   </td>
                            <td><input id="actual_reliability" required name="actual_reliability" value="{{$score->actual_reliability}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    <input id="r" value="@if($reliability) {{$reliability->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                    {{-- <input id="reliability" required name="reliability" value="{{$score->reliability}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="reliability">{{$score->reliability}} </span>
                                    <input type="hidden" name="reliability" id="r_val" value="{{$score->reliability}}">
                                </div>
                                </div>
                            </td>
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
            // var quality = $("#quality").val();
            // var productivity = $("#productivity").val();
            // var reliability = $("#reliability").val();

            var q = $("#q").val();
            var p = $("#p").val();
            var r = $("#r").val();

            var actual_quality = $("#actual_quality").val();
            var actual_productivity = $("#actual_productivity").val();
            var actual_reliability = $("#actual_reliability").val();

            var quality = (q / 100) * actual_quality;
            var productivity = (p / 100) * actual_productivity;
            var reliability = (r / 100) * actual_reliability;

            quality = isNaN(quality) ? 0 : quality;
            productivity = isNaN(productivity) ? 0 : productivity;
            reliability = isNaN(reliability) ? 0 : reliability;

            quality = quality > q ? q : quality;
            productivity = productivity > p ? p : productivity;
            reliability = reliability > r ? r : reliability;

            $("#q_val").val(parseFloat(quality).toFixed(2));
            $("#p_val").val(parseFloat(productivity).toFixed(2));
            $("#r_val").val(parseFloat(reliability).toFixed(2));

            $("#quality").html(parseFloat(quality).toFixed(2));
            $("#productivity").html(parseFloat(productivity).toFixed(2));
            $("#reliability").html(parseFloat(reliability).toFixed(2));

            var totalScore = parseFloat(quality) + parseFloat(productivity) + parseFloat(reliability);
            $("#totalScoreLbl").html(parseFloat(totalScore).toFixed(2) + "%");
            $("#final_score").val(parseFloat(totalScore).toFixed(2));
            console.log(totalScore);
        }
        </script>
@endsection
