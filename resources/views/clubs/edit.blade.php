@extends('layout')

@section('content')

  <? /* TODO: Add club name here */ ?>
  <h1>Add placeholder images</h1>

  <form enctype="multipart/form-data" >

    <div class="form-group">
      <label for="placeholders">Placeholders:</label>
      <input
        type="file"
        name="placeholders"
        class="form-control"
        value="{{ old('placeholders') }}">
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Add Placeholders</button>
    </div>

  </form>

@stop
