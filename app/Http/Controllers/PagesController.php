<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

  public function __construct() {
    parent::__construct();
  }

  public function home(User $user = null) {
    $user = $this->user;
    return view('pages.home', ['user' => $user]);
  }
}
