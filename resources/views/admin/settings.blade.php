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
@endsection
