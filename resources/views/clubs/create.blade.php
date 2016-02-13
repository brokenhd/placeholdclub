@extends('layout')

@section('content')

  <h1>Create a club</h1>

  <div class="row">
    <form enctype="multipart/form-data" method="POST" action="/clubs" class="col-md-6">

      {{ csrf_field() }}

      <div class="form-group">
        <label for="name">Club Name:</label>
        <input
          type="text"
          name="name"
          class="form-control"
          value="{{ old('name') }}"
          required>
      </div>

      <div class="form-group">
        <label for="description">Club Description:</label>
        <input
          type="textarea"
          name="description"
          class="form-control"
          value="{{ old('description') }}">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Create Club</button>
      </div>

      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

    </form>


  </div>

@stop
