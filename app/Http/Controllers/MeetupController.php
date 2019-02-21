<?php

namespace App\Http\Controllers;

use App\Meetup;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Nexmo;

class MeetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $talkUri = $request->input('talkUri');
        $http = new Client();
        $res = $http->get($talkUri)->getBody()->getContents();
        $talk = json_decode($res)->talks[0];
        $meetups = Meetup::whereNull('user_two_id')->where('talk_uri', $talkUri)->get();
        if ($meetups->count() > 0) {
            $meetup = $meetups->first();
            $meetup->user_two_id = auth()->user()->id;
            $meetup->save();
            // Notify new attendee
            Nexmo::message()->send([
                'to' => auth()->user()->phone,
                'from' => 'PHPUK',
                'text' => sprintf(
                    'Hey there! %s already signed up up for the talk "%s". Meet them at the entrance of the %s',
                    $meetup->userOne->name,
                    $talk->talk_title,
                    $talk->tracks[0]->track_name
                )
            ]);
            // Notify previously signed up person
            Nexmo::message()->send([
                'to' => $meetup->userOne->phone,
                'from' => 'PHPUK',
                'text' => sprintf(
                    'Hey there! %s just signed up up for the talk "%s". Meet them at the entrance of the %s',
                    $meetup->userTwo->name,
                    $talk->talk_title,
                    $talk->tracks[0]->track_name
                )
            ]);
        } else {
            $meetup = new Meetup();
            $meetup->user_one_id = auth()->user()->id;
            $meetup->talk_uri = $talkUri;
            $meetup->save();
//            Nexmo::message()->send([
//                'to' => auth()->user()->phone,
//                'from' => 'PHPUK',
//                'text' => sprintf(
//                    'There is currently nobody signe up for the talk %s. We will notify you when somebody signed up.',
//                    $talk->talk_title,
//                )
//            ]);
        }
        return redirect('/talks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function show(Meetup $meetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function edit(Meetup $meetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meetup $meetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meetup  $meetup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meetup $meetup)
    {
        //
    }
}
