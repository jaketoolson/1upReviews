@extends('layouts.account_withsubmenu')

@section('sub-content')

    <form action="/account/password" method="POST">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}
        <div class="form-group mb-3">
            <label for="old_password" class="font-weight-medium">Old password</label>
            <input tabindex="1" class="form-control" type="password" id="old_password" name="old_password" placeholder="Enter your old password">
        </div>
        <div class="form-group mb-3">
            <label for="new_password" class="font-weight-medium">New password</label>
            <input tabindex="1" class="form-control" type="password" id="new_password" name="new_password"  placeholder="Enter a new password">
        </div>
        <div class="form-group mb-3">
            <label for="new_password_confirmation" class="font-weight-medium">Confirm password</label>
            <input tabindex="1" class="form-control" type="password" id="new_password_confirmation" name="new_password_confirmation"  placeholder="Confirm new password">
        </div>
        <div class="form-group mt-4">
            <button class="btn btn-success waves-effect waves-light mb-2" type="submit">Update password</button>
        </div>
    </form>

@endsection