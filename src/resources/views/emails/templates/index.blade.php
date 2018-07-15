@extends('layouts.main')


@section('content')

    <div class="float-right">
        <a href="/emails/templates/create" class="btn btn-outline-primary w-xs">Create New</a>
    </div>

    <h4 class="m-t-0 header-title">
        Email Templates - All
    </h4>


    <table class="table table-plain">
        <thead>
        <tr>
            <th>ID</th>
            <th>Campaign Name</th>
            <th>Date</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($emailTemplates as $emailTemplate)
            <tr>
                <td>{{ $emailTemplate->id }}</td>
                <td>{{ $emailTemplate->name }}</td>
                <td>{{ OneUpReviews\Helpers\DateHelper::convertTimestampToFormat($emailTemplate->created_at) }}</td>
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