@extends('layouts.dco-app')

@section('content')
<h3>Settings</h3>
<hr>
<div class="row">
    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')
    </div>

    <div class="col-md-4">
        <form method="POST" action="{{route('towerhead.store')}}">
                @csrf
                <label for="value">Tower Head</label>
                <input type="text" class="form-control" name="value" id="value" autocomplete="off" value="{{$towerhead->value}}">
                <button type="submit" style="margin-top: 10px;" onclick="return confirm('Are you sure you want to Change Towear Head?')" class="btn btn-sm btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
        </form>
    </div>

</div>

<div class="row">
    <div class="col-md-4">
        <form method="POST" action="{{route('target.store')}}">
                @csrf
                <label for="target">Target %</label>
                <input type="text" class="form-control" name="target" id="target" autocomplete="off" value="@if($target) {{$target->value}} @else {{ 0 }} @endif">
                <button type="submit" style="margin-top: 10px;" onclick="return confirm('Are you sure you want to Change Target %?')" class="btn btn-sm btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <form method="POST" action="{{route('weightage.store')}}">
            <label for="value">Weightage</label>
            <div style="border: 1px solid gray; border-radius:4px; padding: 10px;">
                @csrf
                <label for="quality">Quality</label>
                <input type="text" class="form-control" name="quality" id="quality" autocomplete="off" value="@if($quality) {{$quality->value}} @else {{ 0 }} @endif">
                <label for="productivity" style="margin-top: 10px;">Productivity</label>
                <input type="text" class="form-control" name="productivity" id="productivity" autocomplete="off" value="@if($productivity) {{$productivity->value}} @else {{ 0 }} @endif">
                <label for="reliability" style="margin-top: 10px;">Reliability</label>
                <input type="text" class="form-control" name="reliability" id="reliability" autocomplete="off" value="@if($reliability) {{$reliability->value}} @else {{ 0 }} @endif">
                <label for="profit" style="margin-top: 10px;">Profit</label>
                <input type="text" class="form-control" name="profit" id="profit" autocomplete="off" value="@if($profit) {{$profit->value}} @else {{ 0 }} @endif">
                <label for="engagement" style="margin-top: 10px;">Engagement</label>
                <input type="text" class="form-control" name="engagement" id="engagement" autocomplete="off" value="@if($engagement) {{$engagement->value}} @else {{ 0 }} @endif">
                <label for="behavior" style="margin-top: 10px;">Behavior</label>
                <input type="text" class="form-control" name="behavior" id="behavior" autocomplete="off" value="@if($behavior) {{$behavior->value}} @else {{ 0 }} @endif">
                <label for="partnership" style="margin-top: 10px;">Partnership</label>
                <input type="text" class="form-control" name="partnership" id="partnership" autocomplete="off" value="@if($partnership) {{$partnership->value}} @else {{ 0 }} @endif">
                <label for="priority" style="margin-top: 10px;">Priority</label>
                <input type="text" class="form-control" name="people" id="priority" autocomplete="off" value="@if($priority) {{$priority->value}} @else {{ 0 }} @endif">
                <button type="submit" style="margin-top: 10px;" onclick="return confirm('Are you sure you want to Change Weightage?')" class="btn btn-sm btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
