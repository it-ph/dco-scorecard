@extends('layouts.dco-app')

@section('content')
<h3><strong>Employee Positions</strong></h3>

<div class="row" style="margin-bottom: 10px">
    <div class="col-md-12 text-right">
        <button title="Add Position" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addPosition" type="button"><span class="btn-label"><i class="mdi mdi-account-box"></i></span>Add</button>
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
                        <td>Position</td>
                        <td>Created At</td> 
                        <td>Updated At</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $position)
                    <tr>
                        <td class="table-dark-border">{{ucwords($position->position)}}</td>
                        <td class="table-dark-border">{{$position->created_at->format('M d Y')}}</td>
                        <td class="table-dark-border">{{$position->updated_at->format('M d Y')}}</td>
                        <td class="table-dark-border" style="width: 150px; text-align: center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu animated flipInY" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    
                                    <span class="dropdown-item text-center">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$position->id}}"><i class="fa fa-edit"></i> Edit</button>
                                    
                                    </span>

                                   <span class="dropdown-item text-center">
                                    <form method="POST" action="{{route('admin-positions.destroy', ['id' => $position->id])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete, {{$position->position}}?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</button>
                                    </form>
                                    </span>
                                </div>
                            </div><!--btn-group-->

                            
                            <!-- Modal -->
                            <div id="edit{{$position->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #04B381">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Editing {{ucwords($position->position)}}</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="{{route('admin-positions.update', ['id' => $position->id])}}">
                                     @csrf
                                     @method('PUT')
                                        <input type="text" name="position" class="form-control" value="{{$position->position}}">
                                    </div>
                                    <div class="modal-footer">
                                    <button ty[e="submit" onclick="return confirm('Are you sure you want to Change this Position?')" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
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

@include('admin.positions.add_modal')

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