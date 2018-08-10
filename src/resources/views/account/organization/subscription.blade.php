@extends('layouts.account_withsubmenu')

@section('sub-content')

    <form action="/account/organization/subscription" method="POST">
        {!! csrf_field() !!}
        {!! method_field('delete') !!}
        <div class="form-group mt-4">
            <button class="btn btn-outline-danger waves-effect waves-light mb-2" type="submit">Cancel subscription</button>
        </div>
    </form>

@endsection