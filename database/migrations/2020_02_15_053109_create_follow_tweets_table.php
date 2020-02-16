<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_tweets', function (Blueprint $table) {
            $table->bigIncrements('follow_tweet_id');
            $table->unsignedBigInteger('follows_id');
            $table->unsignedBigInteger('tweet_id');
            $table->timestamps();

            $table->index('follows_id');
            $table->index('tweet_id');

            $table->foreign('follows_id')->references('follows_id')->on('follows')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tweet_id')->references('tweet_id')->on('tweets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_tweets');
    }
}
