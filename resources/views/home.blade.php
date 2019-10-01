@extends('layouts.dco-app')

@section('content')
<h3>Hello, <strong>{{strtoupper(Auth::user()->name)}}!</strong></h3>
@endsection
