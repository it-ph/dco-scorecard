@extends('layouts.dco-app')

@section('content')
<h3> <strong> Scorecard Builder <i class="fa fa-cogs"></i> <strong> </h3>
<hr>
<div class="row">
    <div class="col-md-12">
            @include('notifications.success')
            @include('notifications.error')

    </div>
     

    <div class="col-md-6">
        <form method="POST" action="{{route('template.store')}}">
        @csrf
        <label for="">Template Name <span class="require-icon">*</span></label>
        <input type="text" name="name" class="form-control"><br><br>
        
    </div>
    <div class="col-md-1">
            <label>&nbsp;</label>
            <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to Create this Template?')"> <i class="fa fa-floppy-o"></i> Save</button>
        </form>
    </div>

</div><!--row-->

<hr>
<div class="row">
    {{-- <div class="col-md-1"></div> --}}
    <div class="col-md-11">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="background:#026C4E; color: white; font-weight: bold">SCORECARD TEMPLATES</th>
                    <th style="background:#026C4E; color: white" colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $template)
                <tr>
                <td>{{$template->name}}</td>
                <td style="text-align: right">
                    <a href="{{url('v2/admin/template/column/create')}}/{{$template->id}}"">
                        <button class="btn btn-warning btn-sm">run Wizard <i class="fa fa-chevron-right"></i> </button>
                    </a>
                </td>

                <td style="text-align: left">
                    <form method="POST" action="{{route('template.destroy',['templateId'=>$template->id])}}">
                    @csrf
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Template?')"> <i class="fa fa-times"></i></button>
                    </form>
                </td>
          
                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>





@endsection
