@extends('layout.app')

@section('main')
  @foreach($data as $key => $tweet)
    <a href="javascript:void()" class="tweet-item">
      <h4>{{ $tweet->username }} | <span class="meta-date">{{ $tweet->tweet_create_date }}</span></h4>
      <p>{{ $tweet->tweet }}</p> 
    </a>
  @endforeach
@endsection