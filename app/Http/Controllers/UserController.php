<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index($username)
    {
        $tweet = new Tweet();

        $data = $tweet->get_tweets($username);
        dd($data);

        return view('app/feed');
    }
}
