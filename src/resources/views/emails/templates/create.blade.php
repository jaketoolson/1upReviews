@extends('layouts.main')


@section('content')

    <h4 class="header-title m-t-0">
        Email Templates - New
    </h4>
    <p class="text-muted font-14 m-b-20">
        Lorem ipsum.
    </p>
    <form action="/emails/templates" method="POST">
        {{csrf_field()}}

        <div class="form-group">
            <label for="name">
                Template Name<span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" name="name" placeholder="">
        </div>
        <div class="form-group">
            <label for="name">
                Template Subject<span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" name="subject" placeholder="">
        </div>
        <div class="form-group">
            <label for="name">
                Template Body<span class="text-danger">*</span>
            </label>
            <textarea class="form-control" rows="10" name="body"></textarea>
        </div>
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-success waves-effect waves-light">Create</button>
            </div>
        </div>
    </form>

@endsection