@extends('layouts.account_withsubmenu')

@section('sub-content')

    <form action="/account/settings" method="POST">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}
        <div class="row mb-3">
            <div class="form-group col-sm-6 mb-0">
                <label for="first_name" class="font-weight-medium">First Name</label>
                <input tabindex="1" class="form-control" type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="Enter your first name">
            </div>
            <div class="form-group col-sm-6 mb-0">
                <label for="last_name" class="font-weight-medium">Last Name</label>
                <input tabindex="1" class="form-control" type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" placeholder="Enter your last name">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="email" class="font-weight-medium">Email address</label>
            <input tabindex="1" class="form-control" type="text" id="email" name="email" value="{{ $user->email }}"  placeholder="Enter your email">
        </div>
        <div class="form-group row text-center mt-4">
            <div class="col-12">
                <button class="btn btn-block btn-success waves-effect waves-light mb-2" type="submit">Update profile</button>
            </div>
        </div>
    </form>

@endsection