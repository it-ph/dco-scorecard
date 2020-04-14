@extends('layouts.dco-app')

@section('content')
<h3>Template Name : <strong>{{strtoupper($template->name)}}</strong></h3>
<hr>
<div class="row">
    <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')

    </div>
     
{{-- 
    <div class="col-md-4">
        <form method="POST" action="{{route('template.store')}}">
        @csrf
        <label for="">Column Name <span class="require-icon">*</span></label>
        <input type="text" name="name" class="form-control"><br><br>
        <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to Create this Template?')">Create</button>
        </form>
    </div> --}}

         
    <div class="col-md-10">
         <ol style="margin: 0px" class="cd-breadcrumb triangle">
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view template Lists"><a style="font-size: 16px" href="{{url('v2/admin/template/create')}}">Template</a></li>
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view Columns"><a style="font-size: 16px" href="{{url('v2/admin/template/column/create')}}/{{$template->id}}">Columns</a></li>
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view Contents"><a style="font-size: 16px" href="{{url('v2/admin/template/content/create')}}/{{$template->id}}">Contents</a></li>
                    <li class="current" ><em style="font-size: 14px;background: #28a745;border-color: #28a745;">Remarks</em></li>
                </ol> 

</div><!--md10-->
<div class="col-md-2">
         
    <a href="{{url('/v2/admin/template/preview')}}/{{$template->id}}/1"><button class="btn btn-sm btn-secondary">Preview Card</button></a>
</div><!--md2-->

   
    <div class="col-md-10" style="margin-top: 20px">    
        <form method="POST" action="{{route('template.remarks.store',['templateId'=>$template->id])}}"> 
            @csrf       
            <table class="table borderless" id="dynamic_field_attachment">  
                <tr>  
                    <td><input class="form-control" type="text" name="name"></td>  
                    </tr>  
                </table> 
       <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to Create this Remarks?')"><i class="fa fa-floppy-o"></i> Save</button>
        </form>
    </div><!--div 11-->  

    @if(count($templateRemarks) > 0)
    {{-- <div class="col-md-1"></div> --}}
    <div class="col-md-11" style="background: white; margin-top: 20px">  
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="background: #026C4E; color: white;font-weight: bold">DEFINITION</th>
                    <th colspan="2" style="background: #026C4E; color: white;"></th>
               
                </tr>
            </thead>
        @foreach($templateRemarks as $remarks)
            <tr>
                <td>
                    {{strtoupper($remarks->name)}}
                </td>

                
                
            <td style="text-align: right">
                <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal-{{$remarks->id}}"><i class="fa fa-pencil"></i> </button>
            
                <!-- Modal -->
                <div id="editModal-{{$remarks->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                    
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Remarks field</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('template.remarks.update',['remarksId'=>$remarks->id])}}"> 
                                @csrf 
                                <input type="text" value="{{ $remarks->name }}" class="form-control" name="name">
                                <button class="btn btn-success" onclick="return confirm('Are you sure you want to update this Remarks?')" style="margin-top: 20px">Update</button>
                                </form>
                                
                            </div><!--modal body-->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    
                        </div>
                    </div>
            </td>

            <td style="text-align: left">
                    <form method="POST" action="{{route('template.remarks.destroy',['remarksId'=>$remarks->id])}}"> 
                        @csrf 
                        <button class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this Remarks?')"><i class="fa fa-times"></i> </button>
                    </form>
                </td>

            
            </tr>
        @endforeach
        </table>
    </div>
    @endif

</div><!--div row-->





@endsection