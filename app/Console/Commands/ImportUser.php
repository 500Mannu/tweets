<?php

namespace App\Console\Commands;

use App\User;
use App\Models\Follow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:get {file}';

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
        $raw = $this->argument('file');
        $file = file($raw, FILE_IGNORE_NEW_LINES);
        $users = "";
        $delimiter = ' follows ';
        
        for ($i = 0; $i < count($file); $i++)
        {
            $data = explode($delimiter, $file[$i]);
            //dd($data);
            for ($x = 0; $x < count($data); $x++)
            {
                $users .=  $data[$x] . ", ";
            }
        }

        DB::transaction(function () use ($file, $users, $delimiter) {
            $data = array_unique(explode(', ', $users));
            
            try
            {
                //dd($data);
                foreach ($data as $key => $username)
                {
                    if ($username != "" || $username != null)
                    {
                        $user = new User();

                        $user->username = $username;
                        $user->save();
                    }
                }

                $udata = User::all();

                for ($j = 0; $j < count($file); $j++)
                {
                    $follows = explode(', ', explode($delimiter, $file[$j])[1]);
                    $uid = $udata[$j]->user_id;

                    for ($y = 0; $y < count($follows); $y ++) // 1, 
                    {
                        $follow = new Follow();
                        $userobj = User::where('username', $follows[$y])->first();
                        $fdata = Follow::where([
                            'user_id' => $uid,
                            'follows' => $userobj->user_id
                        ])->count();
                        
                        if ($fdata == 0)
                        {
                            $follow->user_id = $uid;
                            $follow->follows = $userobj->user_id;
                            $follow->save();
                        }
                    }
                }
            }
            catch (Exception $e)
            {
                
            }
        });
    }
}
