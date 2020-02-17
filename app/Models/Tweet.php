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

    protected $fillable = [
        'tweet', 'tweet_create_date'
    ];

    /**
     * Undocumented function
     *
     * @param [type] $username
     * @return App/User
     */
    public function get_tweets()
    {
        $users = DB::table('users as u')->join('tweets as t', 'u.user_id', '=', 't.user_id')->get();
        
        return $users;
    }

    public function get_user_feed($username)
    {
        $tweets = DB::select(DB::raw(
            "select * from users u join tweets t on u.user_id = t.user_id 
            join follows f on u.user_id = f.user_id
            where username = '" . $username . "'
            union
            select * from users ur join tweets tw on ur.user_id = tw.user_id 
            join follows fl on ur.user_id = fl.user_id
            where ur.user_id = (select f.follows from users u join follows f on u.user_id = f.user_id where u.username = '". $username ."')
            order by tweet_create_date desc;"
        ));

        return $tweets;
    }
}