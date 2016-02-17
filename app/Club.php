<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model {

  protected $fillable = ['name', 'description', 'slug'];
  protected $appends = ['uri'];

  /**
   * Declare relationships
   */
  public function placeholders() { return $this->hasMany('App\Placeholder'); }
  public function users() { return $this->belongsToMany('App\User')->withTimestamps(); }

  /**
   * Add the placeholder image to the club
   */
  public function addPlaceholder(Placeholder $placeholder) {
    return $this->placeholders()->save($placeholder);
  }

  /**
   * Get the path to the club
   */
  public function getUriAttribute() {
    return '/clubs/' . $this->slug;
  }

}
