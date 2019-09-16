@extends('layouts.dco-app')

@section('content')
<h3><strong>ROLES</strong></h3>

<div class="row" style="margin-bottom: 10px">
    <div class="col-md-11"></div>
    <div class="col-md-1">
        <button title="Add Role" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addRole" type="button"><span class="btn-label"><i class="mdi mdi-account-box"></i></span>Add</button>
    </div>
</div>
<div class="row">
 
    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')

        <div class="card">
            <div class="card-body">

            <table id="scorecard_datatable" class="display nowrap table table-hover table-bordered dataTable " cellspacing="0" width="100%">            
                <thead style="background: #04b381; color: white; font-weight: bold">
                    <tr>
                        <td>Role</td>
                        <td>Created At</td> 
                        <td>Updated At</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ucwords($role->role)}}</td>
                        <td>{{$role->created_at->format('M d Y')}}</td>
                        <td>{{$role->updated_at->format('M d Y')}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu animated flipInY" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    
                                    <span class="dropdown-item text-center">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$role->id}}"><i class="fa fa-edit"></i> Edit</button>
                                    
                                    </span>

                                   <span class="dropdown-item text-center">
                                    <form method="POST" action="{{route('admin-roles.destroy', ['id' => $role->id])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete, {{$role->role}}?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</button>
                                    </form>
                                    </span>
                                </div>
                            </div><!--btn-group-->

                            
                            <!-- Modal -->
                            <div id="edit{{$role->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #04B381">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Editing {{ucwords($role->role)}}</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="{{route('admin-roles.update', ['id' => $role->id])}}">
                                     @csrf
                                     @method('PUT')
                                        <input type="text" name="role" class="form-control" value="{{$role->role}}">
                                    </div>
                                    <div class="modal-footer">
                                    <button ty[e="submit" onclick="return confirm('Are you sure you want to Change this Role?')" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            
                                </div>
                            </div><!-- Modal -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-md-12-->
</div><!--row-->

@endsection

@include('admin.roles.add_modal')

@section('js')
@include('js_addons')
<script>
        $(document).ready(function() {
          var table = $('#scorecard_datatable').DataTable( {
            "pagingType": "full_numbers",
          
              orderCellsTop: true,
              fixedHeader: true,
              dom: 'Bfrtip',
              buttons: [
                  'excel', 'print'
              ],
                 
      
      
          } );
      } );
</script>
@endsection