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

  /**
   * Add the placeholder image to the club
   */
  public function addPlaceholder(Placeholder $placeholder) {
    return $this->placeholders()->save($placeholder);
  }

}
