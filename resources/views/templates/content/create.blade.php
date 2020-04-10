@inject('templateQueries', 'App\helpers\templateQueries')
@extends('layouts.dco-app')

@section('css')
<style>
th{
    background: #f8ad00;
    color: white;
    font-size: 14px !important;
}

.table td{
    /* font-size: 14px !important; */
    border: 1px solid lightgrey;
}
</style>
@endsection


@section('content')
<h3>Template Wizard </h3>
<hr>
<div class="row">
    <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')

    </div>
     
    <div class="col-md-12">
                <ol style="margin: 0px" class="cd-breadcrumb triangle">
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view template Lists"><a style="font-size: 16px" href="{{url('v2/admin/template/create')}}">Template</a></li>
                    <li data-toggle="tooltip" data-placement="top" data-original-title="view Columns"><a style="font-size: 16px" href="{{url('v2/admin/template/column/create')}}/{{$template->id}}">Columns</a></li>
                    <li class="current"><em  style="font-size: 16px; background: #28a745;">Content</em></li>
                    </ol>
        
        
    </div><!--md12-->
    <div class="col-md-12" style="margin-top: 20px">

           

        <div class="table-responsive">
            <table class="table table-bordered table-striped" >
                <thead>
                    <tr>
                    
                        @foreach($templatecolumn as $column)
                            <th style="text-align: center">{{strtoupper($column->column_name)}}
                                <form method="POST" action="{{route('template.column.destroy',['templateId'=>$template->id,'columnPosition'=>$column->column_position,'columnId'=>$column->id])}}"> 
                                    @csrf 
                                    <button  data-toggle="tooltip" data-placement="top" data-original-title="Delete Entire Column" class="btn btn-xs btn-danger" onclick="return confirm('Deleting this Column will delete all its Content, Confirm?')"><strong><i class="fa fa-times"></i></strong> </button>
                                </form>
                            </th>
                        @endforeach
                        <th></th>
                    </tr>
                </thead>
                        <tbody>
                            @if($templatecontent_lastrow)
                                <?php $lastrow = $templatecontent_lastrow->row_position; ?>
                                <?php $row = $templatecontent_lastrow->row_position + 1; ?>
                            

                                {{-- ANG COLUMN AY : {{count($templatecolumn) - 1}} <!--add start with 0--> --}}
                                {{-- ANG LAST ROW  AY : {{$lastrow}} <!--add start with 0--> --}}

                         
                                @for ($i = 0; $i <= $lastrow; $i++) <!--row -->
                                <?php $trow = $templateQueries->contentBaseonRow($template->id,$i); ?>
                                    <tr>
                                    
                                        @for ($j = 0; $j+1 <= count($templatecolumn) ; $j++) <!--column -->
                                            <?php $tq = $templateQueries->contentBaseOnRowAndColumnPosition($template->id,$i,$j); ?>

                                    
                                    
                                    @if($tq) <!--check if has result -->  
                                        <td>

                                                <div class="row" id="actionBtn-row{{$i}}-col{{$j}}" style="margin-top: 5px;text-align: center;">
                                          
                                                        <button style="margin-left: 10px" class="btn btn-xs btn-default" data-toggle="modal" data-target="#editModal-row{{$i}}-col{{$j}}"><i class="fa fa-pencil"></i> Edit </button>
                                              
    
                                                    
                                                          <!--delete content-->
                                                        @if(!empty($tq->content))
                                                            <form method="POST" action="{{route('template.content.destroy',['templateContentId'=>$tq->id])}}"> 
                                                            @csrf 
                                                            <button style="margin-left: 10px" class="btn btn-xs btn-default delete-btn-{{$j}}" onclick="return confirm('Are you sure you want to delete this Content?')"><i class="fa fa-times"></i> Delete </button>
                                                            </form>
                                                        @endif
                                                        <!--delete content -->
                                                 
    
                                                </div><!--divrow-->
                                            {!! nl2br($tq->content) !!}

                                          
                                          
                                        </td>
                                        <!-- Edit Modal -->
                                        <div id="editModal-row{{$i}}-col{{$j}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                        
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">UPDATE CONTENT</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{route('template.content.update',['templateId'=>$template->id,'rowPosition'=>$i,'columnPosition'=>$j])}}"> 
                                                    @csrf 
                                                    <label for="">content</label>
                                                    <textarea class="form-control" name="content" id="" cols="20" rows="3">{{ $tq->content }}</textarea>
                                                    {{-- <input type="text" value="{{ $tq->content }}" class="form-control" name="content"> --}}
                                                    <button class="btn btn-success" onclick="return confirm('Are you sure you want to update this content?')" style="margin-top: 20px">Update</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        
                                            </div>
                                        </div> <!-- Modal -->

                                        @else
                                           
                                            @if($trow) <!--if has row content-->

                                            <td style="vertical-align: middle;text-align: center"> <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addModal-row{{$i}}-col{{$j}}"><i class="fa fa-plus"></i> </button>
                                            </td>

                                        <!-- Add Modal -->
                                        <div id="addModal-row{{$i}}-col{{$j}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                        
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">ADD CONTENT</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{route('template.content.store',['templateId'=>$template->id])}}"> 
                                                        @csrf 
                                                    
                                                    <input type="hidden" name ="row_position" value="{{$i}}">
                                                        <textarea class="form-control" name="content[]" id="" cols="20" rows="3"></textarea>
                                                    <input type="hidden" name ="column_position[]" value="{{$j}}">
                                                
                                                    
                                                    <button class="btn btn-success" onclick="return confirm('Are you sure you want to Add this content?')" style="margin-top: 20px">Add</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        
                                            </div>
                                        </div> <!-- Modal -->

                                        
                                        
                                            @endif <!--check if row has content-->
                                        @endif <!--end if check result-->
                                        
                                    @endfor

                                    @if($trow)
                                    
                                        <td style="vertical-align: middle; width: 60px;">
                                            <form method="POST" action="{{route('template.content.destroy.row',['templateId'=>$template->id,'rowPosition'=>$i])}}"> 
                                                @csrf 
                                                <button data-toggle="tooltip" data-placement="top" data-original-title="Delete Entire Row" class="btn btn-xs btn-success" onclick="return confirm('Are you sure you want to delete this entire row?')"><strong><i class="fa fa-times"></i></strong></button> 
                                            </form>
                                        </td>
                                    @endif
                                    </tr>
                                @endfor

                                {{-- {{ $templateQueries->contentBaseOnRowAndColumnPosition($template->id,1,1) }} --}}
                            </tr>      
                            @else
                                <?php  $row = 0; ?>
                            @endif
                            <tr>
                                
                                <form method="POST" action="{{route('template.content.store',['templateId'=>$template->id])}}"> 
                                    @csrf 
                                @foreach($templatecolumn as $column)
                                <td>
                                <input type="hidden" name ="row_position" value="{{$row}}">
                                    <textarea class="form-control" name="content[]" id="" cols="20" rows="3"></textarea>
                                <input type="hidden" name ="column_position[]" value="{{$column->column_position}}">
                                 @endforeach
                            </tr>
                            <tr>
                             <td><button class="btn btn-info btn-md" onclick="return confirm('Are you sure you want to Add this Content?')">Add</button> </td>
                            </tr>
                                </form>
                        
                            
                        </tbody>
                    </table>
                </div>
    </div><!--col-md-6-->
</div>





@endsection

@section('js')


@endsection
