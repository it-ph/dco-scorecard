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
<h3>Template Name : <strong>{{strtoupper($template->name)}}</strong></h3>
<hr>
<div class="row">
    <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')

    </div>
     
    <div class="col-md-10">

                    <ol style="margin: 0px" class="cd-breadcrumb triangle">
                        <li data-toggle="tooltip" data-placement="top" data-original-title="view template Lists"><a style="font-size: 16px" href="{{url('v2/admin/template/create')}}">Template</a></li>
                        <li data-toggle="tooltip" data-placement="top" data-original-title="view Columns"><a style="font-size: 16px" href="{{url('v2/admin/template/column/create')}}/{{$template->id}}">Columns</a></li>
                        
                        <li class="current" ><em style="font-size: 14px;background: #28a745;border-color: #28a745;">Contents</em></li>
                        <li data-toggle="tooltip" data-placement="top" data-original-title="view Remarks"><a style="font-size: 16px" href="{{url('v2/admin/template/remarks/create')}}/{{$template->id}}">User Remarks</a></li>    
                    </ol> 
     </div><!--md10-->
     <div class="col-md-2">
         
        <a href="{{url('/v2/admin/template/preview')}}/{{$template->id}}/1"><button class="btn btn-sm btn-secondary">Preview Card</button></a>
    </div><!--md2-->
    <div class="col-md-12" style="margin-top: 20px">
        @if(count($templatecolumn) > 0)
           @include('templates.content.table')
        @else
            <h4 style="font-weight: bold;">Please create Column Header, First!</h4>
        @endif

        
    </div><!--col-md-6-->
</div>





@endsection

@section('js')


@endsection
