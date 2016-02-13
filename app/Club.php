<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model {

  protected $fillable = ['name', 'description'];

  /**
   * Declare relationships
   */
  public function placeholders() {
    return $this->hasMany('App\Placeholder');
  }

}
