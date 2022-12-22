 <!-- Modal -->
 <div id="edit{{$user->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background : #04B381; color: white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white">Editing {{ucwords($user->name)}}</h4>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{route('users.update',['id'=> $user->id])}}">
             @csrf
             @method('PUT')
             <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="emp_id">Employee ID <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <input type="text" value="{{$user->emp_id}}" required name="emp_id" class="form-control fform" id="emp_id">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Fullname <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <input type="text" value="{{$user->name}}" required name="name" class="form-control fform" id="name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        {{-- <div class="form-group">
                            <label for="supervisor">Supervisor</label>
                            <input type="text" value="{{$user->supervisor}}" name="supervisor" class="form-control fform" id="supervisor">
                        </div> --}}

                        <div class="form-group">
                            <label for="supervisor">Supervisor <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="supervisor" id="supervisor" class="form-control fform">
                                    <option value="{{$user->supervisor}}">@if($user->thesupervisor){{ ucwords($user->thesupervisor['name']) }}@endif</option>
                                    <option value=""></option>
                                    @foreach ($supervisors as $key => $val)
                                    @if (old('supervisor') == $val->supervisor)
                                    <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                                    @else
                                    <option value="{{$user->supervisor}}">@if($user->thesupervisor){{ ucwords($user->thesupervisor['name']) }}@endif</option>
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

                    <div class="col-md-12">
                        <label for="manager">Manager <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <select name="manager" id="manager" class="form-control">
                            <option value="{{$user->manager}}">@if($user->themanager){{ ucwords($user->themanager['name']) }}@endif</option>
                            <option value=""></option>
                            @foreach ($managers as $key => $val)
                            @if (old('manager') == $val->manager)
                            <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                            @else
                            <option value="{{$user->manager}}">@if($user->themanager){{ ucwords($user->themanager['name']) }}@endif</option>
                            @endif
                            @endforeach
                            </select>

                        @error('manager')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="role">Department<span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="department_id" id="department_id" class="form-control">
                                <option value="{{$user->department_id}}">@if($user->thedepartment){{strtoupper($user->thedepartment['department'])}}@endif</option>
                                @foreach ($departments as $key => $val)
                                @if (old('department_id') == $val->department)
                                <option value="{{ $val->id }}" selected>{{ strtoupper($val->department) }}</option>
                                @else
                                    <option value="{{ $val->id }}">{{ strtoupper($val->department) }}</option>
                                @endif
                                @endforeach
                                </select>

                            @error('department_id')
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
                                <option value="{{$user->position_id}}">@if($user->theposition){{$user->theposition['position']}}@endif</option>
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
                                <label for="manager">Role <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="role" required id="role" class="form-control fform">
                                    <option value="{{$user->role}}">{{ucwords($user->role)}}</option>
                                    @foreach ($roles as $key => $val)
                                        <option value="{{ $val->role }}">{{ strtoupper($val->role) }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-10">
                                <div class="form-group">
                                    <label for="password">Password <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                    <input id="password" placeholder="Leave Blank to NOT Change." type="password" class="form-control @error('password') is-invalid @enderror" name="password" required">
                                </div>
                            </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="manager">Status <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="status" required id="status" class="form-control fform">
                                    @if(old('status'))
                                        <option value="{{old('status')}}">{{old('status')}}</option>
                                    @elseif($user->status == 'active')
                                        <option value="active">Active</option>
                                        <option value="deactivated">Deactivate</option>
                                    @else
                                        <option value="deactivated">Deactivate</option>
                                        <option value="active">Active</option>
                                    @endif

                                </select>
                            </div>
                        </div>

            </div><!--modal-body-->
            <div class="modal-footer">
            <button type="submit" onclick="return confirm('Are you sure you want to Change this User?')" class="btn btn-info"><i class="fa fa-save"></i> Submit</button>
            </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

        </div>
    </div>
<!--modal end-->
