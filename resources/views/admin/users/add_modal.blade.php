@section('modal')
<!-- Modal -->
<div id="addUser" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="color: white">Add User</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('users.store')}}">
                @csrf
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="emp_id">Employee ID <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <input type="text" required name="emp_id" value="{{old('emp_id')}}" class="form-control" id="emp_id">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Fullname <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <input type="text" required name="name" value="{{old('name')}}" class="form-control fform" id="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="supervisor">Supervisor <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="supervisor" id="supervisor" class="form-control fform">
                                    <option></option>
                                    @foreach ($supervisors as $key => $val)
                                    @if (old('supervisor') == $val->supervisor)
                                    <option value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                                    @else
                                        <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                                    @endif
                                    @endforeach
                                    </select>
                                
                                @error('supervisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    </div>
            
                    <div class="col-md-6">
                        <div class="form-group">
                                <label for="manager">Manager <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                    <select name="manager" id="manager" class="form-control">
                                        <option></option>
                                        @foreach ($managers as $key => $val)
                                        @if (old('manager') == $val->manager)
                                        <option value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                                        @else
                                            <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                    
                                    @error('manager')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                              <label for="role">Position <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="position_id" id="position" class="form-control">
                                    <option></option>
                                    @foreach ($positions as $key => $val)
                                    @if (old('position_id') == $val->position)
                                    <option value="{{ $val->id }}" selected>{{ strtoupper($val->position) }}</option>
                                    @else
                                        <option value="{{ $val->id }}">{{ strtoupper($val->position) }}</option>
                                    @endif
                                    @endforeach
                                    </select>
                                
                                @error('position_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                          </div>
                      </div>

                      <div class="col-md-6">

                          <div class="form-group">
                                <label for="role">Role <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                  <select name="role" id="role" class="form-control">
                                      <option></option>
                                      @foreach ($roles as $key => $val)
                                      @if (old('role') == $val->role)
                                      <option value="{{ $val->role }}" selected>{{ strtoupper($val->role) }}</option>
                                      @else
                                          <option value="{{ $val->role }}">{{ strtoupper($val->role) }}</option>
                                      @endif
                                      @endforeach
                                      </select>
                                  
                                  @error('role')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                          
                            </div>
                        </div>

                        <div class="col-md-10">
                                <div class="form-group">
                                    <label for="password">Password <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <input id="password" type="password" value="" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                </div>
                            </div>
            
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="manager">Status <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="status" required id="status" class="form-control fform">
                                    @if(old('status'))
                                        <option value="{{old('status')}}">{{old('status')}}</option>
                                    @else 
                                    <option value="active">Active</option>
                                    <option value="deactivate">Deactivate</option>
                                    @endif
                                
                                </select>
                            </div>
                        </div>
                </div>
    
             
            </div><!--body-->
            <div class="modal-footer">
                <button class="btn btn-info" type="submit" onclick="return confirm('Are you sure you want to add this User?')"><i class="mdi mdi-content-save"></i> Save</button>
            </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
          </div>
      
        </div>
      </div>
@endsection