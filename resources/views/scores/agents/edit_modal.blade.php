@section('modal')
<!-- Modal -->
<div id="#edit{{$score->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="color: white"></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('agent-score.store')}}">
                @csrf
               
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="month">Month <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="month" id="month" class="form-control">
                                <option value="{{$dt->addMonth()->format('Y-m-d') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('Y-m-d') }}" selected>{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('Y-m-d') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('Y-m-d') }}">{{$dt1->subMonth()->format('M Y') }}</option>
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
                        <tr>
                            <td><span style="font-weight: bold"> QUALITY (OVER-ALL) <small>40%</small></span>   </td>
                            <td><input id="quality" required name="quality" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold"> PRODUCTIVITY <small>40%</small></span>   </td>
                                <td><input id="productivity" required name="productivity" value="0" onkeyup="sumTotalScore()"  type="number" class="form-control" placeholder="%"></td>
                            </tr>

                        <tr>
                            <td><span style="font-weight: bold"> RELIABILITY <small>20%</small><br>
                                    <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span>   </td>
                            <td><input id="reliability" required name="reliability" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold"> PROFIT <small>10%</small><br>
                                    <small></small>
                                </span>   </td>
                            <td><input id="profit" required name="profit" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold"> ENGAGEMENT <small>5%</small><br>
                                    <small></small>
                                </span>   </td>
                            <td><input id="engagement" required name="engagement" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold"> BEHAVIOR <small>5%</small><br>
                                    <small></small>
                                </span>   </td>
                            <td><input id="behavior" required name="behavior" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold"> PARTNERSHIP <small>10%</small><br>
                                    <small></small>
                                </span>   </td>
                            <td><input id="partnership" required name="partnership" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold"> PRIORITY <small>10%</small><br>
                                    <small></small>
                                </span>   </td>
                            <td><input id="priority" required name="priority" value="0" onkeyup="sumTotalScore()" type="number" class="form-control" placeholder="%"></td>
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

@section('js')
<script nonce="{{csp_nonce()}}">
function sumTotalScore()
{
    let quality = $("#quality").val();
    let productivity = $("#productivity").val();
    let reliability = $("#reliability").val();
    let profit = $("#profit").val();
    let engagement = $("#engagement").val();
    let behavior = $("#behavior").val();
    let partnership = $("#partnership").val();
    let priority = $("#priority").val();

    quality = isNaN(quality) ? 0 : quality;
    productivity = isNaN(productivity) ? 0 : productivity;
    reliability = isNaN(reliability) ? 0 : reliability;
    profit = isNaN(profit) ? 0 : profit;
    engagement = isNaN(engagement) ? 0 : engagement;
    behavior = isNaN(behavior) ? 0 : behavior;
    partnership = isNaN(partnership) ? 0 : partnership;
    priority = isNaN(priority) ? 0 : priority;
    alert(profit)

    let totalScore = parseInt(quality) + parseInt(productivity) + parseInt(reliability) + parseInt(profit) + parseInt(engagement) + parseInt(behavior) + parseInt(partnership) + parseInt(priority);
    $("#totalScoreLbl").html(totalScore + "%");
    $("#final_score").val(totalScore)
    console.log(totalScore);
}
</script>
@endsection
