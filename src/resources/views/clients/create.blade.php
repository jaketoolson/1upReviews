@extends('layouts.main')


@section('content')

    <h4 class="header-title m-t-0">
        Clients - New
    </h4>
    <p class="text-muted font-14 m-b-20">
        Lorem ipsum.
    </p>
    <form action="/clients" method="POST">
        {{csrf_field()}}

        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="name">
                    Client First Name<span class="text-danger">*</span>
                </label>
                <input type="text" name="first_name" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
                <label for="name">
                    Client Last Name<span class="text-danger">*</span>
                </label>
                <input type="text" name="last_name" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="name">
                Client Email Address<span class="text-danger">*</span>
            </label>
            <input type="text" name="email_address" class="form-control">
        </div>
        <div class="form-group">
            <label for="name">
                Client Business Name
            </label>
            <input type="text" name="business_name" class="form-control">
        </div>
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
            </div>
        </div>
    </form>

@endsection