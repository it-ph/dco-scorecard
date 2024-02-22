@section('modal')
<!-- Modal -->
<div id="addAgentScore" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="color: white; ">Agent Scorecard </h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('agent-score.store')}}">
                @csrf

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="month_type">Month Type <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="month_type" id="month_type" class="form-control">
                                <option value=""></option>
                                <option value="mid">mid</option>
                                <option value="end">end</option>
                            </select>
                            @error('month_type')
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
                                <option value="{{$dt->addMonth()->format('M Y') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}" selected>{{$dt1->subMonth()->format('M Y') }}</option>
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
                        <span style="font-size: 20px; text-align: center; font-weight: bold" id="target">0% </span> <input type="hidden" required name="target" value="{{ $target->value }}" class="form-control" id="target">
                    </div> --}}
                    <h4> Target : </h4>
                        <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                            <span style="font-size: 20px; text-align: center;" id="targetlbl">@if($target) {{$target->value}} @else {{ 0 }} @endif% </span>
                            <input type="hidden" name="target" id="target" value="@if($target) {{$target->value}} @else {{ 0 }} @endif">
                        </div>
                </div>

                <div class="col-md-3">
                        <h4><strong> FINAL SCORE : </strong></h4>
                        <span style="font-size: 20px; text-align: center; font-weight: bold" id="totalScoreLbl">0% </span> <input type="hidden" name="final_score" id="final_score">

                </div>

            </div><!--row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="role">Agents <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="agent_id" required id="agent_id" class="form-control">
                                    <option></option>
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
                        <tr style="background: #026b4d; color: white">
<!--                             <td>Remarks</td> -->
                            <td style="font-weight: 400">Metrics</td>
                            <td style="font-weight: 400">Actual Score</td>
                            <td style="font-weight: 400">Weightage</td>
                        </tr>
                        <tr>
<!--                             <td><input id="actual_remarks"  name="actual_remarks" value="{{$score->actual_remarks}}" type="text"  class="form-control"></td> -->
                            <td><span style="font-weight: bold; "> QUALITY (OVER-ALL) <small>@if($quality) {{$quality->value}} @else {{ 0 }} @endif%</small></span>   </td>
                            <td><input id="actual_quality" required name="actual_quality" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="q" value="@if($quality) {{$quality->value}} @else {{ 0 }} @endif" type="hidden" class="form-control" placeholder="%">
                                {{-- <input id="quality" required name="quality" value="0" type="text" class="form-control"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="quality">0.00 </span>
                                    <input type="hidden" name="quality" id="q_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> PRODUCTIVITY <small>@if($productivity) {{$productivity->value}} @else {{ 0 }} @endif%</small></span>   </td>
                            <td><input id="actual_productivity" required name="actual_productivity" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="p" value="@if($productivity) {{$productivity->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="productivity" required name="productivity" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="productivity">0.00 </span>
                                    <input type="hidden" name="productivity" id="p_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold;"> RELIABILITY <small>@if($reliability) {{$reliability->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span>   </td>
                            <td><input id="actual_reliability" required name="actual_reliability" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="r" value="@if($reliability) {{$reliability->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="reliability" required name="reliability" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="reliability">0.00 </span>
                                    <input type="hidden" name="reliability" id="r_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold;"> PROFIT <small>@if($profit) {{$profit->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> </small></span>   </td>
                            <td><input id="actual_profit" required name="actual_profit" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="pt" value="@if($profit) {{$profit->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="profit" required name="profit" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="profit">0.00 </span>
                                    <input type="hidden" name="profit" id="pt_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold;"> ENGAGEMENT <small>@if($engagement) {{$engagement->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> </small></span>   </td>
                            <td><input id="actual_engagement" required name="actual_engagement" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="e" value="@if($engagement) {{$engagement->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="engagement" required name="engagement" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="engagement">0.00 </span>
                                    <input type="hidden" name="engagement" id="e_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold;"> BEHAVIOR <small>@if($behavior) {{$behavior->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> </small></span>   </td>
                            <td><input id="actual_behavior" required name="actual_behavior" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="b" value="@if($behavior) {{$behavior->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="behavior" required name="behavior" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="behavior">0.00 </span>
                                    <input type="hidden" name="behavior" id="b_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold;"> PARTNERSHIP <small>@if($people) {{$partnership->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> </small></span>   </td>
                            <td><input id="actual_partnership" required name="actual_partnership" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="ps" value="@if($partnership) {{$partnership->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="partnership" required name="partnership" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="partnership">0.00 </span>
                                    <input type="hidden" name="partnership" id="ps_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold;"> PRIORITY <small>@if($priority) {{$priority->value}} @else {{ 0 }} @endif%</small><br>
                                    <small> </small></span>   </td>
                            <td><input id="actual_priority" required name="actual_priority" value="0" type="text" class="form-control" placeholder="%" onkeyup="sumTotalScore()"></td>
                            <td>
                                <input id="ps" value="@if($priority) {{$priority->value}} @else {{ 0 }} @endif" type="hidden" class="form-control">
                                {{-- <input id="priority" required name="priority" value="0" type="text" class="form-control" placeholder="%"> --}}
                                <div style="border: 1px solid #D9D9D9; border-radius:4px; padding: 4px;">
                                    <span style="font-size: 16px; text-align: center;" id="priority">0.00 </span>
                                    <input type="hidden" name="priority" id="py_val" value="0.00">
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>

            </div><!--row-->

            </div><!--body-->
            <div class="modal-footer">
                <button class="btn btn-info" type="submit" onclick="return confirm('Are you sure you want to add this Score?')"><i class="mdi mdi-content-save"></i> Save</button>
            </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
          </div>

        </div>
      </div>
@endsection

