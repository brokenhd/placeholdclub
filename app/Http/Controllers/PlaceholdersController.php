<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Placeholder;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlaceholdersController extends Controller
{

  public function __construct() {
    parent::__construct();
  }

  public function destroy($id) {
    Placeholder::findOrFail($id)->delete();

    return back();
  }
}
