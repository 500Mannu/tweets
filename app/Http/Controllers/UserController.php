<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $tweets = new Tweet();

        $data = $tweets->get_tweets();
        
        return view('tweets.tweets', [ 
            'data' => $data
        ]);
    }

    public function get_user_feed($username)
    {
        $tweet = new Tweet();
        
        $data = $tweet->get_user_feed($username);

        return view('tweets/userfeed', [
            'data' => $data
        ]);
    }
}
