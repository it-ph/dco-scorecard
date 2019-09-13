@extends('layouts.app')

@section('content')
<div class="container">
    @include('notifications.success')
    @include('notifications.error')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
        <h4><strong> USERS LISTS</strong> <a href="{{route('users.create')}}" style="font-size: 14px; font-weight: bold; float: right">Add User</a></h4>
            <table class="table">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Date Created</th>
                    <th style="text-align: center" colspan="2">Actions</th>
                </tr>
                </thead>
            @foreach($users as $user)
                <tr>
                    <td>{{ ucwords($user->name) }}</td>
                    <td><span style="@if($user->role == 'admin') font-weight:bold @endif">{{ ucwords($user->role) }}</td>
                    <td>{{ ucwords($user->created_at->format('m-d-Y')) }}</td>
                    <td style="text-align: right">
                    <form method="GET" action="{{route('users.edit', ['id' => $user->id])}}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                    </form>
                    </td>
                    <td>
                        <form method="POST" action="{{route('users.destroy', ['id' => $user->id])}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete {{ucwords($user->name)}}\'s  record?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
</div>
@endsection
