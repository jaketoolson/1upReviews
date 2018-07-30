@extends('layouts.auth')

@section('content')

    <form action="/account/register" method="POST">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="company_name" class="font-weight-medium">Company Name</label>
            <input tabindex="1" class="form-control" type="text" id="company_name" name="company_name" placeholder="Enter your company name">
        </div>
        <div class="row mb-3">
            <div class="form-group col-sm-6 mb-0">
                <label for="first_name" class="font-weight-medium">First Name</label>
                <input tabindex="1" class="form-control" type="text" id="first_name" name="first_name" placeholder="Enter your first name">
            </div>
            <div class="form-group col-sm-6 mb-0">
                <label for="last_name" class="font-weight-medium">Last Name</label>
                <input tabindex="1" class="form-control" type="text" id="last_name" name="last_name" placeholder="Enter your last name">
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="email" class="font-weight-medium">Email address</label>
            <input tabindex="1" class="form-control" type="text" id="email" name="email" placeholder="Enter your email">
        </div>
        <div class="form-group mb-3">
            <label for="password" class="font-weight-medium">Password</label>
            <input tabindex="2" name="password" class="form-control"
                   type="password"
                   id="password"
                   placeholder="Enter your password">
        </div>
        <div class="form-group mb-3">
            <p class="text-center">By clicking Create Account, I agree to the Terms of service and Policy Privacy.</p>
        </div>
        <div class="form-group row text-center mt-4">
            <div class="col-12">
                <button class="btn btn-block btn-success waves-effect waves-light mb-2" type="submit">Create Account</button>
                <a href="/account/login" class="btn btn-link">or log into existing account</a>
            </div>
        </div>
    </form>

@endsection