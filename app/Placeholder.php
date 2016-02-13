<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Placeholder extends Model {

  protected $table = 'placeholders';

  protected $fillable = ['placeholder'];

  public function club() {
    return $this->belongsTo('App\Club');
  }

}
