<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;

class Club extends Model {

  protected $fillable = ['name', 'description', 'slug'];
  protected $appends = ['uri'];

  public static $rules = array(
    'name' => 'required|unique:clubs'
  );

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
   * Return a random placeholder from the group
   * @return string
   */
  public function randomPlaceholder($width, $height) {

    // TODO: Try to always use images that are always bigger than
    // the type requested

    $img = $this->placeholders()->get()->shuffle()->first()->path;
    $crop = Image::make($img);

    $crop->fit($width, $height);
    return $crop->response();
  }

  /**
   * Get the path to the club
   */
  public function getUriAttribute() {
    return '/clubs/' . $this->slug;
  }

}
