 <!-- Modal -->
 <div id="add_position{{$user->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header" style="background : #04B381; color: white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: white">Add Position to {{ucwords($user->name)}}</h4>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{route('users.position.store')}}">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" required name="user_id" value="{{ $user->id }}" class="form-control">

                            <label for="department">Department <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                            <select name="department_id" id="department" class="form-control fform">
                                <option></option>
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

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="position">Position <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="supervisor">Supervisor </label>
                            <select name="supervisor_id" id="supervisor" class="form-control fform">
                                <option></option>
                                @foreach ($supervisors as $key => $val)
                                @if (old('supervisor') == $val->supervisor)
                                <option value="{{ $val->id }}" >{{ strtoupper($val->name) }}</option>
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
                        <div class="form-group">
                            <label for="manager">Manager</label>
                            <select name="manager_id" id="manager" class="form-control">
                                <option></option>
                                @foreach ($managers as $key => $val)
                                @if (old('manager') == $val->manager)
                                <option value="{{ $val->id }}" >{{ strtoupper($val->name) }}</option>
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
                </div>


            </div><!--body-->
            <div class="modal-footer">
                <button class="btn btn-info" type="submit" onclick="return confirm('Are you sure you want to add position for this User?')"><i class="mdi mdi-content-save"></i> Save</button>
            </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

    </div>
</div>
<!--modal end-->
