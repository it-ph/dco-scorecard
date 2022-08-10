@section('modal')
<!-- Modal -->
<div id="addTlScore" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="color: white">Team Leader Scorecard</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('tl-score.store')}}">
                @csrf
               
            <div class="row">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="target">Target % <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <input type="text" required name="target" value="{{old('target')}}" class="form-control" id="target">
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
                        <label for="role">Team Leaders <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="tl_id" required id="tl_id" class="form-control">
                                    <option></option>
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
                </div><!--row-->
            <div class="row">
                
                <div class="col-md-12">
                    <table class="display nowrap table table-bordered dataTable">
                        <tr style="background: #026b4d; color: white">
                            <td style="font-weight: 400">Metrics</td>
                            <td style="font-weight: 400">Actual Score</td>
                            <td style="font-weight: 400">Score</td>
                        </tr>
                        <tr>
                            <td><span style="font-weight: bold; "> QUALITY (OVER-ALL) <small>20%</small></span>   </td>
                            <td><input id="actual_quality" autocomplete="off" required name="actual_quality" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="quality" autocomplete="off" required name="quality" value="0" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> PRODUCTIVITY <small>15%</small></span>   </td>
                            <td><input id="actual_productivity" autocomplete="off" required name="actual_productivity" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="productivity" autocomplete="off" required name="productivity" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> ADMIN & COACHING <small>30%</small>  </td>
                            <td><input id="actual_admin_coaching" autocomplete="off" required name="actual_admin_coaching" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="admin_coaching" autocomplete="off" required name="admin_coaching" value="0" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM PERFORMANCE <small>15%</small></span>   </td>
                            <td><input id="actual_team_performance" autocomplete="off" required name="actual_team_performance" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_performance" autocomplete="off" required name="team_performance" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> INITIATIVE <small>5%</small></span>   </td>
                            <td><input id="actual_initiative" autocomplete="off" required name="actual_initiative" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="initiative" autocomplete="off" required name="initiative" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM ATTENDANCE <small>15%</small><br>
                                <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span>   </td>
                            <td><input id="actual_team_attendance" autocomplete="off" required name="actual_team_attendance" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_attendance" autocomplete="off" required name="team_attendance" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
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

