<?php

namespace App\Http\Controllers;

use App\Meetup;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $http = new Client();
        $res = $http->get('http://api.joind.in/v2.1/events/7001/talks?resultsperpage=100')->getBody()->getContents();
        $talks = collect(json_decode($res)->talks);
        $talks = $talks->filter(function ($talk) {
            return !in_array($talk->tracks[0]->track_name, [
                'Workshop Track',
                'Social',
            ]);
        });
        $talks->map(function ($talk) {
            $talk->start_time = new Carbon($talk->start_date);
            $talk->end_time = $talk->start_time->copy();
            $talk->end_time->addMinutes($talk->duration);
            return $talk;
        });
//        dd($talks);
        $meetups = Meetup::where('user_one_id', auth()->user()->id)->orWhere('user_two_id', auth()->user()->id)->get();
        $meetupUris = $meetups->map(function ($meetup) {
            return $meetup->talk_uri;
        })->toArray();
//        $talks = $talks->filter(function ($talk) use ($meetupUris) {
//            return !in_array($talk->uri, $meetupUris);
//        });
        return view('talks.index', compact('talks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
