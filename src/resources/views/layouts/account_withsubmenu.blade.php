@extends('layouts.main')

@section('content')

    <div class="inbox-leftbar">
        <div class="mail-list mb-3">
            <h6 class="list-group-item-heading list-group-item">
                Personal
            </h6>
            <a href="/account/settings" class="list-group-item ">
                Settings
            </a>
            <a href="/account/password" class="list-group-item ">
                Password
            </a>
            <a href="#" class="list-group-item ">
                Email Notifications
            </a>
        </div>

        <div class="mail-list">
            <h6 class="list-group-item-heading list-group-item">
                Organization
            </h6>
            <a href="/account/organization/settings" class="list-group-item ">
                Settings
            </a>
            <a href="/account/organization/subscription" class="list-group-item ">
                Subscription
            </a>
            <a href="/account/organization/card" class="list-group-item ">
                Credit Card
            </a>
            <a href="#" class="list-group-item ">
                Receipts
            </a>
        </div>
    </div>

    <div class="inbox-rightbar">
        @yield('sub-content')
    </div>

    <div class="clearfix"></div>


@endsection