@extends('layout')

@section('content')

  <div class="jumbotron">

    @if ($signedIn)
      @if ($user)

        <h2>Clubs</h2>
        <hr>

        @if ($user->clubs()->exists())
          @foreach ($user->clubs()->get() as $club)
            <a href="{{$club->uri}}">{{ $club->name }}</a>
          @endforeach
        @endif

        <hr>
        <a href="clubs/create" class="btn btn-primary">Create a Club</a>

      @else

        <h2>You're clubless!</h2>
        <p>Make a club now and stop being a dork.</p>
        <a href="clubs/create" class="btn btn-primary">Create a Club</a>

      @endif

    @else

      <h2>Want to join the fun?</h2>
      <p>Join us and create your own placeholder club!</p>
      <a href="/register" class="btn btn-primary">Register</a>

    @endif

  </div>

@stop
