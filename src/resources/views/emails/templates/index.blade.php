@extends('layouts.main')


@section('content')

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
        @for($i = 0; $i<50; $i++)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ Faker\Factory::create()->words(mt_rand(3, 6), true) }}</td>
                <td>{{ date('F d, Y', mt_rand(1, time())) }}</td>
                <td>
                    <a href="#" class="card-drop">
                        <i class="icon-options"></i>
                    </a>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

@endsection