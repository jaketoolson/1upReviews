@extends('layouts.account_withsubmenu')

@section('sub-content')

    <form action="/account/organization/settings" method="POST">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}
        <div class="form-group mb-3">
            <label for="name" class="font-weight-medium">Organization name</label>
            <input tabindex="1" class="form-control" type="text" id="name" name="name" value="{{ $organization->name }}"  placeholder="Enter organization name">
        </div>
        <div class="form-group mb-3">
            <label for="social_focus_id" class="font-weight-medium">Default social focus</label>
            <select tabindex="2" class="form-control" name="social_focus_id">
                @foreach($socialFocii as $focus)
                    <option value="{{ $focus['id'] }}" @if($focus['id'] === $organization->social_focus_id) selected @endif>{{ $focus['friendly_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group row text-center mt-4">
            <div class="col-12">
                <button class="btn btn-block btn-success waves-effect waves-light mb-2" type="submit">Update organization</button>
            </div>
        </div>
    </form>

@endsection