@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Talk</th>
                    <th>Track</th>
                    <th>Match me!</th>
                </tr>
                </thead>
                <tbody>
                @foreach($talks as $talk)
                    <tr>
                        <td> {{$talk->start_time->format('Y-m-d H:i')}} </td>
                        <td> {{$talk->talk_title}} </td>
                        <td> {{$talk->tracks[0]->track_name}} </td>
                        <td>
                            <form action="/meetups" method="POST">
                                @csrf
                                <input type="hidden" name="talkSlug" value="{{$talk->stub}}">
                                <button type="submit" class="btn btn-sm btn-success">Match me!</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
