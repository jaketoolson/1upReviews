@extends('layouts.main')


@section('content')

    <h4 class="header-title m-t-0">
        Email - New
    </h4>
    <p class="text-muted font-14 m-b-20">
        Lorem ipsum.
    </p>
    <form action="/emails/campaigns" method="POST">
        {{csrf_field()}}

        <div class="form-group">
            <label for="name">
                Email Template<span class="text-danger">*</span>
            </label>
            <select name="email_template_id" class="form-control">
                @foreach($emailTemplates as $emailTemplate)
                    <option value="{{ $emailTemplate->id }}">{{ $emailTemplate->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">
                Client<span class="text-danger">*</span>
            </label>
            <select name="client_id" class="form-control">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-success waves-effect waves-light">Send</button>
                <a href="javascript: void(0);" class="btn btn-link">Preview</a>
            </div>
        </div>
    </form>

@endsection