@extends('layouts.dco-app')

@section('content')
<h3 style="color: #003A5D"><strong><i class="fa fa-key"></i> Password </strong></h3>
<hr>
<div class="row">
    <div class="col-md-4">
            @include('notifications.success')
            @include('notifications.error')

        <div class="box">
            <div class="box-body">
                <form method="POST" action="{{route('user.store')}}">
                @csrf
                <label for="password">New Password</label>
                <input type="password" class="form-control" name="password" id="password"><br>
                <button type="submit" style="margin-top: 20px" onclick="return confirm('Are you sure you want to Change your Password?')" class="btn btn-sm btn-primary pull-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
