@extends('layouts.app')

@section('content')
<div class="container">
    @include('notifications.success')
    @include('notifications.error')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <h4 style="align:center"><strong> Ooop! you're not AUTHORIZED to view this page.</strong></h4>
            <p>If you think this is an error. please contact your system administrator.</p>
            <a class="nav-link" href="{{ route('home') }}"><button class="btn btn-primary btn-md">Go Home</button></a>
            
        </div>
    </div>
</div>
@endsection
