@extends('layouts.dco-app')

@section('content')
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-9">
        <strong> <strong> Template Wizard <i class="fa fa-cogs"></i> <strong> </strong>
    </div>
    <div class="col-md-2 pull-right">
            <button class="btn btn-info btn-sm" onclick="toggleAdd()"><i id="createIcon" class="fa fa-chevron-circle-down"></i> Create</button>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')

    </div>
     
</div>
<div class="row" id="addDiv"  style="display: none">
    <div class="col-md-6" style="margin-bottom: 20px">
        <form method="POST" action="{{route('template.store')}}">
        @csrf
        <label for="">Create Template <span class="require-icon">*</span></label>
        <input type="text" name="name" placeholder="Name" class="form-control"><br><br>
        <input type="number" name="default_target_score" placeholder="Default Target Score" class="form-control"><br><br>
        <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to Create this Template?')"><i class="fa fa-floppy-o"></i> Save</button>
        </form>
    </div>
  
    <hr>
</div><!--row-->


<div class="row">
    {{-- <div class="col-md-1"></div> --}}
    <div class="col-md-11">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="background:#026C4E; color: white; font-weight: bold">SCORECARD TEMPLATES</th>
                    <th style="background:#026C4E; color: white; font-weight: bold;text-align: center">DEFAULT<br>TARGET SCORE </th>
                    
                    <th style="background:#026C4E; color: white" colspan="3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr>
                <td>{{$template->name}}</td>
                <td style="text-align: center">{{$template->default_target_score}}</td>
                <td style="text-align: right">
                    <a href="{{url('v2/admin/template/column/create')}}/{{$template->id}}"">
                        <button class="btn btn-info btn-sm">run Wizard <i class="fa fa-chevron-right"></i> </button>
                    </a>
                </td>

                <td style="text-align: right">
                    <form method="POST" action="{{route('template.destroy',['templateId'=>$template->id])}}">
                    @csrf
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Template?')"> <i class="fa fa-times"></i></button>
                    </form>
                </td>

                <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTemplate-{{$template->id}}"><i class="fa fa-pencil"></i> </button>
                </td>
          
                
                </tr>

                <!-- Modal -->
            <div id="editTemplate-{{$template->id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
              
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editing {{$template->name}}</h4>
                    </div>
                        <div class="modal-body">
                           <form method="POST" action="{{route('template.update',['templateId'=>$template->id])}}">
                            @csrf
                            <label>Template Name</label>
                            <input type="text" name="name" placeholder="name" value="{{$template->name}}" class="form-control"><br><br>
                            <label>Default Target Score</label>
                            <input type="text" name="default_target_score" placeholder="Default Target Score" value="{{$template->default_target_score}}" class="form-control"> <br><br>
                            <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to Create this Template?')"><i class="fa fa-floppy-o"></i> Save</button>
                            </form>
                              
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
              
                </div>
              </div>
                <!-- End Modal -->

                @endforeach
            </tbody>
        </table>

        

    </div>
</div>





@endsection
@section('js')
<script>
    function toggleAdd()
    {
        $("#addDiv").slideToggle();
        $("#createIcon").toggleClass("fa-chevron-circle-down fa-chevron-circle-up");
    }

</script>
@endsection