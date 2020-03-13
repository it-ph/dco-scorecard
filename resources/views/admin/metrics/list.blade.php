@extends('layouts.dco-app')

@section('content')
<h3><strong>METRICS</strong></h3>

<div class="row" style="margin-bottom: 10px">
    <div class="col-lg-11"></div>
    <div class="col-lg-1">
        <button title="Add Metrics" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#addMetrics" type="button"><span class="btn-label"><i class="mdi mdi-account-box"></i></span>Add</button>
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
                        <td>Name</td>
                        <td>Alias</td>
                        <td>Weight</td>
                        <td>Target</td>
                        <td>Performance Ranges</td>
                        <td>Score</td>
                        <td>Status</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($departments as $department)
                    <tr>
                        <td class="table-dark-border">{{ucwords($department->department)}}</td>
                        <td class="table-dark-border">{{$department->created_at->format('M d Y')}}</td>
                        <td class="table-dark-border">{{$department->updated_at->format('M d Y')}}</td>
                        <td class="table-dark-border" style="width: 150px; text-align: center" class="table-dark-border">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu animated flipInY" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    
                                    <span class="dropdown-item text-center">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit{{$department->id}}"><i class="fa fa-edit"></i> Edit</button>
                                    
                                    </span>

                                   <span class="dropdown-item text-center">
                                    <form method="POST" action="{{route('departments.destroy', ['id' => $department->id])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete, {{$department->department}}?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</button>
                                    </form>
                                    </span>
                                </div>
                            </div><!--btn-group-->

                            
                            <!-- Modal -->
                            <div id="edit{{$department->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #04B381">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white">Editing {{ucwords($department->department)}}</h4>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="{{route('departments.update', ['id' => $department->id])}}">
                                     @csrf
                                     @method('PUT')
                                        <input type="text" name="department" class="form-control" value="{{$department->department}}">
                                    </div>
                                    <div class="modal-footer">
                                    <button ty[e="submit" onclick="return confirm('Are you sure you want to Change this Department?')" class="btn btn-info"><i class="fa fa-save"></i> Save</button>
                                    </form>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            
                                </div>
                            </div><!-- Modal -->
                        </td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
            
            
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-md-12-->
</div><!--row-->

@endsection

@include('admin.metrics.add_modal')

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