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
  public function owner() { return $this->belongsTo('App\User', 'user_id'); }

  public function ownedBy(User $user) {
    return $this->user_id == $user->id;
  }

  /**
   * Add the placeholder image to the club
   */
  public function addPlaceholder(Placeholder $placeholder) {
    return $this->placeholders()->save($placeholder);
  }

  public function getUriAttribute() {
    return '/clubs/' . $this->slug;
  }

}
