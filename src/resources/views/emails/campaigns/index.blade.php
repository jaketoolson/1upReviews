@extends('layouts.main')


@section('content')


    <div class="float-right">
        <a href="/emails/campaigns/create" class="btn btn-outline-primary w-xs">Send New</a>
    </div>

    <h4 class="m-t-0 header-title">
        Campaign Emails - All
    </h4>


    <table class="table table-plain">
        <thead>
        <tr>
            <th>ID</th>
            <th>Campaign Name</th>
            <th>Client</th>
            <th>Sent At</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($campaignEmails as $campaignEmail)
            <tr>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection