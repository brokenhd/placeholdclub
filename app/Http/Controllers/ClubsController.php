<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Club;
use App\Placeholder;
use App\Http\Requests\ClubRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ClubsController extends Controller {

  public function __construct() {
    $this->middleware('auth', ['except' => ['show']]);
  }

  public function show($slug) {

    $club = Club::where(compact('slug'))->firstOrFail();

    return view('clubs.show', compact('club'));

  }

  public function create() {

    return view('clubs.create');

  }

  public function store(ClubRequest $request) {

    $club = new Club;
    $club->name = $request->name;
    $club->slug = strtolower($request->name);
    $club->description = $request->description;

    $club->save();

    flash()->overlay('Club created!', 'Now start uploading images!');

    return redirect()->back();

  }

  /**
   * Upload the placeholder image
   *
   * @param Request $request [description]
   */
  public function addPlaceholder($slug, Request $request) {

    $this->validate($request, [
      'placeholder' => 'required|mimes:jpg,png,gif'
    ]);

    $placeholder = $this->makePlaceholder($request->file('placeholder'));

    Club::where(compact('slug'))->firstOrFail()->addPlaceholder($placeholder);

  }

  protected function makePlaceholder(UploadedFile $file) {
    return Placeholder::named($file->getClientOriginalName())->move($file);
  }
}
