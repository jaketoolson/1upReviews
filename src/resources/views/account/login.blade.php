@extends('layouts.auth')

@section('content')

    <form action="/account/login" method="POST">
        {{ csrf_field() }}
        <div class="form-group mb-3"><label for="emailaddress" class="font-weight-medium">Email address</label>
            <input tabindex="1" class="form-control" type="text" id="emailaddress" name="email" placeholder="Enter your email"></div>
        <div class="form-group mb-3">
            <a href="#" class="text-muted float-right">
                <small>Forgot your password?</small>
            </a>
            <label for="password" class="font-weight-medium">Password</label>
            <input tabindex="2" name="password" class="form-control"
                   type="password"
                   id="password"
                   placeholder="Enter your password">
        </div>
        <div class="form-group row text-center mt-4">
            <div class="col-12">
                <button class="btn btn-block btn-success waves-effect waves-light mb-2" type="submit">Sign In</button>
                <a href="/account/register" class="btn btn-link">or create a new account</a>
            </div>
        </div>
    </form>

@endsection