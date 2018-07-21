@extends('layouts.main')


@section('content')

    <div class="float-right">
        <a href="/clients/create" class="btn btn-outline-primary w-xs">Create New</a>
    </div>

    <h4 class="m-t-0 header-title">
        Clients - All
    </h4>


    <table class="table table-plain">
        <thead>
        <tr>
            <th>Name</th>
            <th>Business Name</th>
            <th>Email Address</th>
            <th>Last Email</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->full_name }}</td>
                <td>@if($client->business_name) {{ $client->business_name }} @else <i>(none)</i> @endif</td>
                <td>{{ $client->email_address }}</td>
                <td>{{ $client->emails->count() }}</td>
                <td>
                    <a href="#" class="card-drop">
                        <i class="icon-options"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection