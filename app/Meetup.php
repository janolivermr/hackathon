<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meetup extends Model
{
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }
}
