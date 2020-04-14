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
                    <li class="current" ><em style="font-size: 14px;background: #28a745;border-color: #28a745;">Columns</em></li>
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view Contents"><a style="font-size: 16px" href="{{url('v2/admin/template/content/create')}}/{{$template->id}}">Contents</a></li>
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view Remarks"><a style="font-size: 16px" href="{{url('v2/admin/template/remarks/create')}}/{{$template->id}}">User Remarks</a></li>    
                </ol> 

</div><!--md10-->
<div class="col-md-2">
         
    <a href="{{url('/v2/admin/template/preview')}}/{{$template->id}}/1"><button class="btn btn-sm btn-secondary">Preview Card</button></a>
</div><!--md2-->


    <div class="col-md-12" style="margin-top: 30px">   
        <small>e.g.</small> <img src="{{asset('images/column_sample.png')}}">
    </div><!--div 12-->  
   
    <div class="col-md-10" style="margin-top: 20px">    
        <form method="POST" action="{{route('template.column.store',['templateId'=>$template->id])}}"> 
            @csrf       
    @if(count($columns) > 0)
        <table class="table borderless" id="dynamic_field_attachment">  
            <tr>  
                <td><input class="form-control" type="text" name="column_name"></td>  
                </tr>  
            </table> 
     @else
         
        <table class="table borderless" id="dynamic_field_attachment">  
            <tr>  
                <td><input class="form-control" type="text" name="columns[]"></td>  
            </tr>  
        </table> 
        <button class="btn btn-primary waves-effect waves-light" type="button" title="Click to add more column" name="add_column" id="add_column"><span class="btn-label" title="Click to add more Column"><i class="fa fa-plus"></i> </span>Add More</button>
        <hr>
       @endif
       <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to Create this Columns?')"><i class="fa fa-floppy-o"></i> Save</button>
        </form>
    </div><!--div 11-->  

    @if(count($columns) > 0)
    {{-- <div class="col-md-1"></div> --}}
    <div class="col-md-11" style="background: white; margin-top: 20px">  
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="background: #026C4E; color: white;font-weight: bold">COLUMNS</th>
                    <th style="background: #026C4E; color: white;font-weight: bold">IS FILLABLE?</th>
                    <th style="background: #026C4E; color: white;font-weight: bold">IS FINAL SCORE?</th>
                    <th colspan="2" style="background: #026C4E; color: white;"></th>
               
                </tr>
            </thead>
        @foreach($columns as $column)
            <tr>
                <td>
                    {{strtoupper($column->column_name)}}
                </td>

                <td style="text-align: center">
                    <form method="POST" id="fillableId{{$column->id}}" action="{{route('template.column.fillable',['columnId'=>$column->id])}}"> 
                        @csrf 
                       
                        @if($column->is_fillable == 0)
                        <div class="demo-checkbox">
                            <input type="checkbox" id="basic_checkbox_{{$column->id}}" onclick="is_fillable({{$column->id}})"  class="filled-in">
                            <label for="basic_checkbox_{{$column->id}}" onclick="is_fillable({{$column->id}})" ></label>
                           
                        </div>  <input type="hidden" value="1" name="is_fillable">
    
                        {{-- <input type="hidden" value="1" name="is_fillable"> --}}
                        {{-- <button class="btn btn-xs btn-secondary" onclick="return confirm('Confirm this Column is Fillable?')">Make this Fillable</button> --}}
            
                        @else
                        <div class="demo-checkbox">
                            <input type="checkbox" id="basic_checkbox_{{$column->id}}" onclick="is_fillable({{$column->id}})"  checked="" class="filled-in">
                            <label for="basic_checkbox_{{$column->id}}" onclick="is_fillable({{$column->id}})" ></label>
    
                        </div><input type="hidden" value="0" name="is_fillable">  
                          
                        {{-- <input type="hidden" value="0" name="is_fillable">
                        <button class="btn btn-xs btn-danger" onclick="return confirm('Unfillable this Column?')"> <i class="fa fa-times"></i> Unfillable</button> --}}
                       @endif
                       
                    </form>
                </td>

                <td style="text-align: center">
                        <form method="POST" id="finalId{{$column->id}}" action="{{route('template.column.isfinalscore',['columnId'=>$column->id])}}"> 
                            @csrf 
                           
                            @if($column->is_final_score == 0)
                            <div class="demo-checkbox">
                                <input type="checkbox" id="basic_checkbox_{{$column->id}}" onclick="is_final_score({{$column->id}})"  class="filled-in">
                                <label for="basic_checkbox_{{$column->id}}" onclick="is_final_score({{$column->id}})" ></label>
                               
                            </div>  <input type="hidden" value="1" name="is_final_score">
        
                            {{-- <input type="hidden" value="1" name="is_fillable"> --}}
                            {{-- <button class="btn btn-xs btn-secondary" onclick="return confirm('Confirm this Column is Fillable?')">Make this Fillable</button> --}}
                
                            @else
                            <div class="demo-checkbox">
                                <input type="checkbox" id="basic_checkbox_{{$column->id}}" onclick="is_final_score({{$column->id}})"  checked="" class="filled-in">
                                <label for="basic_checkbox_{{$column->id}}" onclick="is_final_score({{$column->id}})" ></label>
        
                            </div><input type="hidden" value="0" name="is_final_score">  
                              
                            {{-- <input type="hidden" value="0" name="is_fillable">
                            <button class="btn btn-xs btn-danger" onclick="return confirm('Unfillable this Column?')"> <i class="fa fa-times"></i> Unfillable</button> --}}
                           @endif
                           
                        </form>
                    </td>
                
            <td style="text-align: right">
                <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#editModal-{{$column->id}}"><i class="fa fa-pencil"></i> </button>
            
                <!-- Modal -->
                <div id="editModal-{{$column->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                    
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Column</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('template.column.update',['columnId'=>$column->id])}}"> 
                                @csrf 
                                <input type="text" value="{{ $column->column_name }}" class="form-control" name="column_name">
                                <button class="btn btn-success" onclick="return confirm('Are you sure you want to update this Column?')" style="margin-top: 20px">Update</button>
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
                    <form method="POST" action="{{route('template.column.destroy',['templateId'=>$template->id,'columnPosition'=>$column->column_position,'columnId'=>$column->id])}}"> 
                        @csrf 
                        <button class="btn btn-xs btn-danger" onclick="return confirm('Deleting this Column will delete all its Content, Confirm?')"><i class="fa fa-times"></i> </button>
                    </form>
                </td>

            
            </tr>
        @endforeach
        </table>
    </div>
    @endif

</div><!--div row-->





@endsection


@section('js')
<script type="text/javascript">
     function is_fillable(num){
        var r = confirm("Confirm Changes?");
        if (r == true) {
            document.getElementById("fillableId" + num).submit();
        }else{
            event.preventDefault();
        }
     }

     function is_final_score(num){
        var r = confirm("Confirm Changes?");
        if (r == true) {
            document.getElementById("finalId" + num).submit();
        }else{
            event.preventDefault();
        }
     }

    
    $(document).ready(function(){      
     
    //Add More Attachment
    // var i=0;  
    var n=0; 
      $('#add_column').click(function(){  

        n++; 

           $('#dynamic_field_attachment').append('<tr id="row'+n+'" class="dynamic-added"><td> <input type="text" class="form-control"  name="columns[]"></td><td><button type="button" name="remove" id="'+n+'" class="btn btn-danger btn_remove_attachment"><i class="fa fa-times"></i></button></td></tr>');  
 
           console.log(n);
      });  


      $(document).on('click', '.btn_remove_attachment', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
  
 
    });  //document ready
</script>


@endsection