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
                                <td>Remarks</td>
                                <td>Metrics</td>
                                <td>Actual Score</td>
                                <td>Weightage</td>
                        </tr>
                        <tr>
                            <td><input id="quality_remarks" required name="quality_remarks" value="{{$score->quality_remarks}}" type="text"  class="form-control"></td>
                            <td><span style="font-weight: bold"> QUALITY (OVER-ALL) <small>@if($quality) {{$quality->value}} @else {{ 0 }} @endif%</small></span>   </td>
                            <td><input id="actual_quality" required name="actual_quality" value="{{$score->actual_quality}}" type="text" class="form-control" placeholder="" onkeyup="sumTotalScore()"></td>
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
                            <td><input id="productivity_remarks" required name="productivity_remarks" value="{{$score->productivity_remarks}}" type="text"  class="form-control"></td>
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
                            <td><input id="reliability_remarks" required name="reliability_remarks" value="{{$score->reliability_remarks}}" type="text"  class="form-control"></td>
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

                        <tr>
                            <td><input id="profit_remarks" required name="profit_remarks" value="{{$score->profit_remarks}}" type="text"  class="form-control"></td>
                            <td><span style="font-weight: bold"> PROFIT <small>@if($profit) {{$profit->value}} @else {{ 0 }} @endif%</small><br>
                                    <small></small></span>   </td>
                            <td><input id="actual_profit" required name="actual_profit" value="{{$score->actual_profit}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    <input id="pt" value="@if($profit) {{$profit->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                    {{-- <input id="profit" required name="profit" value="{{$score->profit}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="profit">{{$score->profit}} </span>
                                    <input type="hidden" name="profit" id="pt_val" value="{{$score->profit}}">
                                </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input id="engagement_remarks" required name="engagement_remarks" value="{{$score->engagement_remarks}}" type="text"  class="form-control"></td>
                            <td><span style="font-weight: bold"> ENGAGEMENT <small>@if($engagement) {{$engagement->value}} @else {{ 0 }} @endif%</small><br>
                                    <small></small></span>   </td>
                            <td><input id="actual_engagement" required name="actual_engagement" value="{{$score->actual_engagement}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    <input id="e" value="@if($engagement) {{$engagement->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                    {{-- <input id="engagement" required name="engagement" value="{{$score->engagement}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="engagement">{{$score->engagement}} </span>
                                    <input type="hidden" name="engagement" id="e_val" value="{{$score->engagement}}">
                                </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input id="behavior_remarks" required name="behavior_remarks" value="{{$score->behavior_remarks}}" type="text"  class="form-control"></td>
                            <td><span style="font-weight: bold"> BEHAVIOR <small>@if($behavior) {{$behavior->value}} @else {{ 0 }} @endif%</small><br>
                                    <small></small></span>   </td>
                            <td><input id="actual_behavior" required name="actual_behavior" value="{{$score->actual_behavior}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    <input id="b" value="@if($behavior) {{$behavior->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                    {{-- <input id="behavior" required name="behavior" value="{{$score->behavior}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="behavior">{{$score->behavior}} </span>
                                    <input type="hidden" name="behavior" id="b_val" value="{{$score->behavior}}">
                                </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input id="partnership_remarks" required name="partnership_remarks" value="{{$score->partnership_remarks}}" type="text"  class="form-control"></td>
                            <td><span style="font-weight: bold"> PARTNERSHIP <small>@if($partnership) {{$partnership->value}} @else {{ 0 }} @endif%</small><br>
                                    <small></small></span>   </td>
                            <td><input id="actual_partnership" required name="actual_partnership" value="{{$score->actual_partnership}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    <input id="ps" value="@if($partnership) {{$partnership->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                    {{-- <input id="partnership" required name="partnership" value="{{$score->partnership}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="partnership">{{$score->partnership}} </span>
                                    <input type="hidden" name="partnership" id="ps_val" value="{{$score->partnership}}">
                                </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><input id="priority_remarks" required name="priority_remarks" value="{{$score->priority_remarks}}" type="text"  class="form-control"></td>
                            <td><span style="font-weight: bold"> PRIORITY <small>@if($priority) {{$priority->value}} @else {{ 0 }} @endif%</small><br>
                                    <small></small></span>   </td>
                            <td><input id="actual_priority" required name="actual_priority" value="{{$score->actual_priority}}" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 5px;">
                                    <input id="py" value="@if($priority) {{$priority->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                    {{-- <input id="priority" required name="priority" value="{{$score->priority}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"> --}}
                                    <span style="font-size: 16px; text-align: center;" id="priority">{{$score->priority}} </span>
                                    <input type="hidden" name="priority" id="py_val" value="{{$score->priority}}">
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
<script nonce="{{csp_nonce()}}">

function sumTotalScore() {
        let q = parseFloat($("#q").val()) || 0;
        let p = parseFloat($("#p").val()) || 0;
        let r = parseFloat($("#r").val()) || 0;
        let pt = parseFloat($("#pt").val()) || 0;
        let e = parseFloat($("#e").val()) || 0;
        let b = parseFloat($("#b").val()) || 0;
        let ps = parseFloat($("#ps").val()) || 0;
        let py = parseFloat($("#py").val()) || 0;

        let actual_quality = parseFloat($("#actual_quality").val()) || 0;
        let actual_productivity = parseFloat($("#actual_productivity").val()) || 0;
        let actual_reliability = parseFloat($("#actual_reliability").val()) || 0;
        let actual_profit = parseFloat($("#actual_profit").val()) || 0;
        let actual_engagement = parseFloat($("#actual_engagement").val()) || 0;
        let actual_behavior = parseFloat($("#actual_behavior").val()) || 0;
        let actual_partnership = parseFloat($("#actual_partnership").val()) || 0;
        let actual_priority = parseFloat($("#actual_priority").val()) || 0;

        let quality = (q / 100) * actual_quality;
        let productivity = (p / 100) * actual_productivity;
        let reliability = (r / 100) * actual_reliability;
        let profit = (pt / 100) * actual_profit;
        let engagement = (e / 100) * actual_engagement;
        let behavior = (b / 100) * actual_behavior;
        let partnership = (ps / 100) * actual_partnership;
        let priority = (py / 100) * actual_priority;

        quality = isNaN(quality) ? 0 : quality;
        productivity = isNaN(productivity) ? 0 : productivity;
        reliability = isNaN(reliability) ? 0 : reliability;
        profit = isNaN(profit) ? 0 : profit;
        engagement = isNaN(engagement) ? 0 : engagement;
        behavior = isNaN(behavior) ? 0 : behavior;
        partnership = isNaN(partnership) ? 0 : partnership;
        priority = isNaN(priority) ? 0 : priority;

        quality = quality > q ? q : quality;
        productivity = productivity > p ? p : productivity;
        reliability = reliability > r ? r : reliability;
        profit = profit > pt ? pt : profit;
        engagement = engagement > e ? e : engagement;
        behavior = behavior > b ? b : behavior;
        partnership = partnership > ps ? ps : partnership;
        priority = priority > py ? py : priority;

        $("#q_val").val(quality.toFixed(2));
        $("#p_val").val(productivity.toFixed(2));
        $("#r_val").val(reliability.toFixed(2));
        $("#pt_val").val(profit.toFixed(2));
        $("#e_val").val(engagement.toFixed(2));
        $("#b_val").val(behavior.toFixed(2));
        $("#ps_val").val(partnership.toFixed(2));
        $("#py_val").val(priority.toFixed(2));

        $("#quality").html(quality.toFixed(2));
        $("#productivity").html(productivity.toFixed(2));
        $("#reliability").html(reliability.toFixed(2));
        $("#profit").html(profit.toFixed(2));
        $("#engagement").html(engagement.toFixed(2));
        $("#behavior").html(behavior.toFixed(2));
        $("#partnership").html(partnership.toFixed(2));
        $("#priority").html(priority.toFixed(2));

        let totalScore = (quality + productivity + reliability + profit + engagement + behavior + partnership + priority);
        $("#totalScoreLbl").html(totalScore.toFixed(2) + "%");
        $("#final_score").val(totalScore.toFixed(2));
        console.log(totalScore);
    }

</script>
@endsection
