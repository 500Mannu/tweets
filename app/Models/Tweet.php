<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tweet extends Model
{
    /**
     * Tweet model primary key
     *
     * @var string
     */
    protected $primaryKey = "tweet_id";

    /**
     * Undocumented function
     *
     * @param [type] $username
     * @return App/User
     */
    public function get_tweets($username)
    {
        $user = User::where('username', $username)->get();

        return $user;
    }

    private function get_follwing_tweets($user_id)
    {

    }
}
