<?php

namespace App\Http\Controllers;

use App\Meetup;
use Illuminate\Http\Request;

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
        $talkSlug = $request->input('talkSlug');
        $meetups = Meetup::whereNull('user_two_id')->where('talk_slug', $talkSlug)->get();
        if ($meetups->count() > 0) {
            $meetup = $meetups->first();
            $meetup->user_two_id = auth()->user()->id;
            $meetup->save();
            // TODO: Send Nexmo
        } else {
            $meetup = new Meetup();
            $meetup->user_one_id = auth()->user()->id;
            $meetup->talk_slug = $talkSlug;
            $meetup->save();
            // TODO: Notify Waiting
        }
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
