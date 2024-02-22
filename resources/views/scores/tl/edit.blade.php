<?php

use carbon\carbon;

$dt = carbon::now();
$dt1 = carbon::now();
?>
@extends('layouts.dco-app')

@section('content')
<h3><strong>Editing Scorecard of : {{strtoupper($score->thetl->name)}}</strong></h3>
<hr>

<div class="row" style="background: white; padding: 10px;">
    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')

        <a href="{{url('scores/tl')}}">
            <button class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> Back to Lists</button>
        </a>
    </div>

    <div class="col-md-1"></div>
    <div class="col-md-6">
        <form method="POST" action="{{route('tl-score.update',['id' => $score->id])}}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="month">Month <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <select name="month" id="month" class="form-control">
                            <option selected value="{{$score->month}}">{{$score->month}}</option>
                            <option value="{{$dt->addMonth()->format('M Y') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                            <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
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

            </div>
            <!--row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="role">Team Leaders <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <select name="tl_id" required id="tl_id" class="form-control">
                            <option value="{{$score->tl_id}}">{{strtoupper($score->thetl->name)}}</option>
                            @foreach ($tls as $key => $val)
                            @if (old('tl_id') == $val->name)
                            <option value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                            @else
                            <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                            @endif
                            @endforeach
                        </select>

                        @error('tl_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>
            </div>
            <!--row-->
            <div class="row">

                <div class="col-md-12">
                    <table class="display nowrap table table-bordered dataTable">
                        <tr style="background: #026b4d; color: white">
                            <td>Remarks</td>
                            <td>Metrics</td>
                            <td colspan="2">Performance Ranges</td>
                            <td colspan="2">Actual Score</td>
                        </tr>
                        <tr>
                            <td>
                                <textarea id="actual_remarks" required name="actual_remarks" value="{{$score->actual_remarks}}" type="text"  class="form-control">
                                    {{$score->actual_remarks}}
                                </textarea>
                            </td>
                            <td rowspan="2" style="font-weight: bold;">Team KPIs</td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>Passed Team Productivity (Weekly SLA)</small>
                            </td>
                            <td class="ttxt-center lbl-bold">20%</td>
                            <td><input id="productivity" autocomplete="off" required name="productivity" value="{{$score->productivity}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>Passed Team Quality (Weekly SLA)</small>
                            </td>
                            <td class="ttxt-center lbl-bold">20%</td>
                            <td><input id="quality" autocomplete="off" required name="quality" value="{{$score->quality}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td rowspan="6"></td>
                            <td rowspan="6" style="font-weight: bold;">TL Deliverables</td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>No client escalations</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="no_client_escalations" autocomplete="off" required name="no_client_escalations" value="{{$score->no_client_escalations}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>No or 1 pay dispute</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="no_pay_dispute" autocomplete="off" required name="no_pay_dispute" value="{{$score->no_pay_dispute}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>Linkedin Learning Compliance</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="linkedin_learning_compliance" autocomplete="off" required name="linkedin_learning_compliance" value="{{$score->linkedin_learning_compliance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>EOD Reporting</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="eod_reporting" autocomplete="off" required name="eod_reporting" value="{{$score->eod_reporting}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>HTL compliance</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="htl_compliance" autocomplete="off" required name="htl_compliance" value="{{$score->htl_compliance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>Other Compliance Required</small>
                            </td>
                            <td class="ttxt-center lbl-bold">25%</td>
                            <td class="ttxt-center lbl-bold"><input id="other_compliances_required" autocomplete="off" required name="other_compliances_required" value="{{$score->other_compliances_required}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td rowspan="4"></td>
                            <td rowspan="4" style="font-weight: bold;">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, <br> ardiness,<br> Overbreak,<br> Undertime)</span></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>>95% reliability</small>
                            </td>
                            <td class="ttxt-center lbl-bold">10%</td>
                            <td rowspan="4" class="ttxt-center lbl-bold"><input id="reliability" style="margin-top: 70px;" autocomplete="off" required name="reliability" value="{{$score->reliability}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <95%>=90% reliability
                                    </small>
                            </td>
                            <td class="ttxt-center lbl-bold">7%</td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <95%>=85% reliability
                                    </small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                        </tr>
                        <tr>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <85% reliability</small> </td> <td class="ttxt-center lbl-bold">0%</td>
                        </tr>

                    </table>
                    <!-- <table class="display nowrap table table-bordered dataTable">
                        <tr style="background: #026B4D; color: white">
                            <td>Metrics</td>
                            <td>Actual Score</td>
                            <td>Score</td>
                        </tr>
                        <tr>
                            <td><span style="font-weight: bold; "> QUALITY (OVER-ALL) <small>20%</small></span> </td>
                            <td><input id="actual_quality" autocomplete="off" required name="actual_quality" value="{{$score->actual_quality}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="quality" autocomplete="off" required name="quality" value="{{$score->quality}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> PRODUCTIVITY <small>15%</small></span> </td>
                            <td><input id="actual_productivity" autocomplete="off" required name="actual_productivity" value="{{$score->actual_productivity}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="productivity" autocomplete="off" required name="productivity" value="{{$score->productivity}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> ADMIN & COACHING <small>30%</small> </td>
                            <td><input id="actual_admin_coaching" autocomplete="off" required name="actual_admin_coaching" value="{{$score->actual_admin_coaching}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="admin_coaching" autocomplete="off" required name="admin_coaching" value="{{$score->admin_coaching}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM PERFORMANCE <small>15%</small></span> </td>
                            <td><input id="actual_team_performance" autocomplete="off" required name="actual_team_performance" value="{{$score->actual_team_performance}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_performance" autocomplete="off" required name="team_performance" value="{{$score->team_performance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> INITIATIVE <small>5%</small></span> </td>
                            <td><input id="actual_initiative" autocomplete="off" required name="actual_initiative" value="{{$score->actual_initiative}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="initiative" autocomplete="off" required name="initiative" value="{{$score->initiative}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM ATTENDANCE <small>15%</small><br>
                                    <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span> </td>
                            <td><input id="actual_team_attendance" autocomplete="off" required name="actual_team_attendance" value="{{$score->actual_team_attendance}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_attendance" autocomplete="off" required name="team_attendance" value="{{$score->team_attendance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                    </table> -->
                </div>

            </div>
            <!--row-->


            <hr>
            <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to add this Score?')"><i class="mdi mdi-content-save"></i> Save</button>
        </form>


    </div>
</div>



@endsection

@section('js')
<script>
    function sumTotalScore() {
        var quality = $("#quality").val();
        var productivity = $("#productivity").val();
        var no_client_escalations = $("#no_client_escalations").val();
        var no_pay_dispute = $("#no_pay_dispute").val();
        var linkedin_learning_compliance = $("#linkedin_learning_compliance").val();
        var eod_reporting = $("#eod_reporting").val();
        var htl_compliance = $("#htl_compliance").val();
        var other_compliances_required = $("#other_compliances_required").val();
        var reliability = $("#reliability").val();

        quality = isNaN(quality) ? 0 : quality;
        productivity = isNaN(productivity) ? 0 : productivity;
        no_client_escalations = isNaN(no_client_escalations) ? 0 : no_client_escalations;
        no_pay_dispute = isNaN(no_pay_dispute) ? 0 : no_pay_dispute;
        linkedin_learning_compliance = isNaN(linkedin_learning_compliance) ? 0 : linkedin_learning_compliance;
        eod_reporting = isNaN(eod_reporting) ? 0 : eod_reporting;
        htl_compliance = isNaN(htl_compliance) ? 0 : htl_compliance;
        other_compliances_required = isNaN(other_compliances_required) ? 0 : other_compliances_required;
        reliability = isNaN(reliability) ? 0 : reliability;

        var totalScore = parseFloat(quality) + parseFloat(productivity) + parseFloat(no_client_escalations) + parseFloat(no_pay_dispute) + parseFloat(linkedin_learning_compliance) + parseFloat(eod_reporting) + parseFloat(htl_compliance) + parseFloat(other_compliances_required) + parseFloat(reliability);
        $("#totalScoreLbl").html(parseFloat(totalScore).toFixed(2) + "%");
        $("#final_score").val(parseFloat(totalScore).toFixed(2));
        console.log(totalScore);
    }
</script>
@endsection