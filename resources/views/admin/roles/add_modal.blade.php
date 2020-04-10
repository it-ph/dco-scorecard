@section('modal')
<!-- Modal -->
<div id="addRole" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" style="color: white">Add Role</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('admin-roles.store')}}">
                @csrf
                <div class="form-group">
                    <label class="control-label">Role</label>
                    <input type="text" id="role" name="role" class="form-control" placeholder="">
                        
                    @error('role')
                    <div class="has-danger">
                        <small class="form-control-feedback"> {{$message}} </small>
                    </div>
                    @enderror
                </div><!--form-group-->

                <div class="form-group">
                    <label class="control-label">Default Template</label>
                    <select class="form-control" name="default_template">
                      <option value="">--Please Select--</option>
                      @foreach($templates as $template)
                        <option value="{{$template->id}}">{{$template->name}}</option>
                      @endforeach
                    </select>
                    @error('role')
                    <div class="has-danger">
                        <small class="form-control-feedback"> {{$message}} </small>
                    </div>
                    @enderror
                </div><!--form-group-->
           

             
            </div>
            <div class="modal-footer">
                <button class="btn btn-info" type="submit" onclick="return confirm('Are you sure you want to add this Role?')"><i class="mdi mdi-content-save"></i> Save</button>
            </form>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
          </div>
      
        </div>
      </div>
@endsection