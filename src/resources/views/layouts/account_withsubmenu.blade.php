@extends('layouts.main')

@section('content')

    <div class="inbox-leftbar">
        <div class="mail-list">
            <a href="/account/settings" class="list-group-item ">
                Profile Settings
            </a>
            <a href="/account/password" class="list-group-item ">
                Change Password
            </a>
            <a href="#" class="list-group-item ">
                Organization Settings
            </a>
        </div>
    </div>

    <div class="inbox-rightbar">
        @yield('sub-content')
    </div>

    <div class="clearfix"></div>


@endsection