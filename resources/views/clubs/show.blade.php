@extends('layout')

@section('content')

  <div class="row">

    <div class="col-md-4">

      <h1>{{ $club->name }}</h1>
      <div class="description">
        {!! $club->description !!}
      </div>

    </div>

    <div class="col-md-8 gallery">

      @foreach ($club->placeholders->chunk(4) as $set)
        <div class="row">
          @foreach ($set as $placeholder)
            <div class="col-md-3 gallery-image">
              <img src="/{{ $placeholder->thumbnail_path }}" alt="">
            </div>
          @endforeach
        </div>
      @endforeach

    </div>
  </div>

  <form
    id="addPlaceholdersForm"
    class="dropzone"
    action="{{ route('store_placeholder_path', [$club->slug]) }}"
    method="POST">

    {{ csrf_field() }}

  </form>

@stop

@section('scripts.footer')

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/dropzone.js">
  </script>

  <script>
    Dropzone.options.addPlaceholdersForm = {
      paramName: 'placeholder',
      maxFilesize: 5,
      acceptedFiles: '.jpg, .jpeg, .png, .gif'
    }
  </script>
