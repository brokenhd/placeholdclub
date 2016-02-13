<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Club;
use App\Http\Requests\ClubRequest;
use App\Http\Controllers\Controller;

class ClubsController extends Controller {

  public function show() {

    return view('clubs.edit');

  }

  public function create() {

    return view('clubs.create');

  }

  public function store(ClubRequest $request) {

    // persist
    Club::create($request->all());

    flash('Club created!');

    return redirect()->back();

  }
}
