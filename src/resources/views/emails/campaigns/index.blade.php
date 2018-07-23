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
            <th>Client</th>
            <th>Sent At</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($campaignEmails as $campaignEmail)
            <tr>
                <td>{{ $campaignEmail->id }}</td>
                <td>{{ $campaignEmail->client->first_name }}</td>
                <td>{{ $campaignEmail->created_at }}</td>
                <td>{{ $campaignEmail->status }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection