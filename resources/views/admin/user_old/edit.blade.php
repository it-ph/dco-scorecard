@extends('layouts.app')

@section('content')
<div class="container">
    @include('notifications.success')
    @include('notifications.error')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{route('users.index')}}"><button style="margin-bottom: 10px" class="btn btn-sm btn-primary">Back to Lists</button></a>
               
            <div class="card">
            <div class="card-header">Update record of {{ucwords($user->name)}}</div>
            <div class="card-body">
                <form method="POST" action="{{route('users.update',['id'=> $user->id])}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="@if( old('name') ){{ old('name')}}@else{{ $user->name }}@endif" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if( old('email') ){{ old('email')}}@else{{ $user->email }}@endif" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>
    
                                <div class="col-md-6">
                                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                        @if($user->role == 'admin')
                                        <option value="admin" selected>Administrator</option> 
                                        <option value="user">User</option>
                                        @else

                                        <option value="admin" >Administrator</option> 
                                        <option value="user" selected>User</option>

                                        @endif
                                    
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Update Password
                            <input style="margin-left: 10px; cursor: pointer" title="Update {{ucwords($user->name)}}'s' Password?" onClick="togglePassword()" type="checkbox" name="changePassword" id="changePassword"></label>

                            <div class="col-md-6">
                                <input id="password" style="display: none" placeholder="Type in new Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                     <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <button type="submit" onclick="return confirm('Are you sure you want to update {{ucwords($user->name)}}\'s account?')" class="btn btn-success">
                                   Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

function togglePassword()
{
    
    if ($("#changePassword").is(':checked')) {
           $('#password').show();
        } else {
            $('#password').hide();
        }
}
</script>
@endsection

