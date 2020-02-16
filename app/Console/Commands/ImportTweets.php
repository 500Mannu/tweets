<?php

namespace App\Console\Commands;

use App\user;
use App\Models\Tweet;
use App\Models\Follow;
use App\Models\FollowTweet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweets:get {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            $raw = $this->argument('file');
            $file = file($raw, FILE_IGNORE_NEW_LINES);

            DB::transaction (function () use($file) {
                for ($i =  0; $i < count($file); $i ++)
                {
                    $len = strpos($file[$i], '>');
                    $str = substr($file[$i], 0, $len);
                    
                    $tokens = explode(' ', $str);
                    $username = $tokens[2];
                    $message = substr($file[$i], $len + 2);
                    $date = $tokens[0] . " " . $tokens[1];

                    $user = User::where('username', $username)->first();
                    
                    $tweet = new Tweet();

                    $tweet->user_id = $user->user_id;
                    $tweet->tweet = $message;
                    $tweet->tweet_create_date = $date;
                    $tweet->save();

                    //
                    $follows = Follow::where('follows', $user->user_id)->get();

                    for ($d = 0; $d < count($follows); $d ++)
                    {
                        $follow_obj = new FollowTweet();

                        $follow_obj->follows_id = $follows[$d]->follows_id;
                        $follow_obj->tweet_id = $tweet->tweet_id;
                        $follow_obj->save();
                    }
                }
            });
        }
        catch (Exception $e)
        {
            
        }
    }
}
