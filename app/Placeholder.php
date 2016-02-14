<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Placeholder extends Model {

  protected $table = 'placeholders';
  protected $fillable = ['path', 'name', 'thumbnail_path'];
  protected $baseDir = 'uploads/placeholders';

  public function club() {
    return $this->belongsTo('App\Club');
  }

  public static function named($name) {

    return (new static)->saveAs($name);

  }

  public function saveAs($name) {

    $this->name = sprintf("%s-%s", time(), $name);
    $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
    $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

    return $this;
  }

  public function move(UploadedFile $file) {

    $file->move($this->baseDir, $this->name);
    $this->makeThumbnail();

    return $this;
  }

  public function makeThumbnail() {

    Image::make($this->path)->fit(200)->save($this->thumbnail_path);

  }

}
