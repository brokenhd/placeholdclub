<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Club;
use App\Placeholder;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPlaceholderRequest;

class ClubsController extends Controller {

  /**
   * Add autho middleware to all of the clubs routes but the show and index
   */
  public function __construct() {
    $this->middleware('auth', ['except' => ['show', 'index']]);

    parent::__construct();
  }

  /**
   * Index method will take you to clubs create for now
   * TODO:: Route this to some sort of clubs listing page, clubs.index
   */
  public function index() {
    return layout('clubs.create');
  }

  /**
   * Detail page for clubs
   *
   * @return [type]       [description]
   */
  public function show($slug) {
    $club = Club::where(compact('slug'))->firstOrFail();

    return layout('clubs.show', compact('club'));
  }

  /**
   * Show the create club view
   */
  public function create() {
    return layout('clubs.create');
  }

  /**
   * Store the created club
   *
   * @param  ClubRequest $request [description]
   * @return redirect to the created club
   */
  public function store(Request $request) {

    $validator = $this->validate($request, [
      'name' => 'required|unique:clubs|alpha_dash|max:30'
    ]);

    $club = new Club;
    $club->name = $request->name;
    $club->slug = strtolower($request->name);
    $club->description = $request->description;

    $club->save();

    $pivotClub = Club::find($club->id);
    $pivotClub->users()->attach($this->user->id);

    flash()->overlay('Club created!', 'Now start uploading images!');
    return redirect("clubs/$club->slug");
  }

  /**
   * Add a placeholder
   *
   * @param string $slug
   * @param Request $request
   */
  public function addPlaceholder($slug, AddPlaceholderRequest $request) {
    $placeholder = Placeholder::fromFile($request->file('placeholder'));
    Club::where(compact('slug'))->firstOrFail()->addPlaceholder($placeholder);
  }
}
