@section('modal')
<!-- Modal -->
<div id="addAgentScore" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white; ">{{strtoupper($role->role)}} Scorecard </h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('v2.score.store',['roleId'=>$role->id])}}" onsubmit="createTemplate()">
                @csrf
               
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="month">Month <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="month" id="month" class="form-control">
                                <option value="{{$dt->addMonth()->format('M Y') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}" selected>{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                                <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
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

                <div class="col-md-6">
                        <div class="form-group">
                            <label for="target">Target</label>
                                <input class="form-control"  type="text" name="target" 
                                 @if(old('target'))
                                 value="{{old('target')}}"
                                 @elseif($role->thetemplate)
                                    value="{{$role->thetemplate['default_target_score']}}"
                                @endif id="target">
                                @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

               

            </div><!--row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="role">Select Employee <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="user_id" onchange="userSelected()" id="select-value-user" class="form-control">
                                    <option></option>
                                    @foreach ($users as $key => $val)
                                    @if (old('user_id') == $val->name)
                                    <option value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                                    @else
                                        <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                                    @endif
                                    @endforeach
                                    </select>
                                
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="template_name" id="template_name" @if($role->thetemplate)
                            value="{{$role->thetemplate['name']}}"
                        @endif >
                                <label for="role">Select Template <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                        <select name="template_id" id="template_id" onchange="updateTemplateId()" class="form-control">
                                            @if($role->thetemplate)
                                                <option value="{{$role->thetemplate['id']}}">{{$role->thetemplate['name']}}</option>
                                            @else 
                                                <option value="">--Please Select--</option>
                                            @endif
                                            @foreach ($scorecard_templates as $key => $val)
                                            <?php $templateChecker = $templateQueries->checkTemplateIfHasContent($val->id); ?>
                                            @if (old('template_id') == $val->name)
                                            <option  value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                                            @else
                                                @if($templateChecker)
                                                <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                                                @endif
                                            @endif
                                            @endforeach
                                            </select>
                                        
                                        @error('template_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                
                                </div>
                    </div>

                    <div class="col-md-12" style="text-align: center">
                        <button id="buildButton" onclick="return confirm('Are you sure you want to generate this Scorecard?')" class=" btn btn-danger btn-lg" style="font-weight: bold">GENERATE SCORE CARD <span class="selectedUser"></span></button>
                        <span style="display: none" id="buildLoading"><img style="width:40px;height:auto" src="{{asset('images/spin-loader.gif')}}" alt=""> generating scorecard for <span class="selectedUser"></span> ... </span>
                    </div>
                </div><!--row-->
            
             
            </div><!--body-->
            <div class="modal-footer">
                {{-- <button class="btn btn-info" type="submit" onclick="return confirm('Are you sure you want to add this Score?')"><i class="mdi mdi-content-save"></i> Save</button>
            </form> --}}
              <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
          </div>
      
        </div>
      </div>
@endsection