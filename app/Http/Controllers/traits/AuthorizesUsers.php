<?php

namespace App\Http\Controllers\Traits;

use App\Club;
use Illuminate\Http\Request;

trait AuthorizesUsers {

  protected function unauthorized(Request $request) {
    if ($request->ajax()) {
      return response(['message' => 'You don\'t own this club.'], 403);
    }

    flash('You aren\'t the owner of this club.');

    return redirect('/');
  }
}
