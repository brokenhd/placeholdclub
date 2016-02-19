<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Placeholder extends Model {

  protected $table = 'placeholders';
  protected $fillable = ['path', 'name', 'thumbnail_path', 'width', 'height'];
  protected $file;

  /**
   * Boot function
   */
  protected static function boot() {
    static::creating(function($placeholder) {
      return $placeholder->upload();
    });
  }

  /**
   * Set up relationships
   */
  public function club() {
    return $this->belongsTo('App\Club');
  }

  /**
   * Make a placeholder image from a file
   * @return placeholder
   */
  public static function fromFile(UploadedFile $file) {
    $placeholder = new static;
    $placeholder->file = $file;

    return $placeholder->fill([
      'name' => $placeholder->fileName(),
      'path' => $placeholder->filePath(),
      'thumbnail_path' => $placeholder->thumbnailPath(),
      'width' => $placeholder->getWidth(),
      'height' => $placeholder->getHeight()
    ]);
  }

  /**
   * Create the file name from the file
   * @return string
   */
  public function fileName() {
    $name = time() . $this->file->getClientOriginalName();
    $extension = $this->file->getClientOriginalExtension();
    return "{$name}.{$extension}";
  }

  /**
   * Create the file path
   * @return string
   */
  public function filePath() {
    return $this->baseDir() . '/' . $this->fileName();
  }

  /**
   * Create the path for the thumbnail
   * @return string
   */
  public function thumbnailPath() {
    return $this->baseDir() . '/tn-' . $this->fileName();
  }

  /**
   * Create the base directory path for uploads
   * @return string
   */
  public function baseDir() {
    return 'uploads/placeholders';
  }

  public function getWidth() {
    return Image::make($this->file)->width();
  }

  public function getHeight() {
    return Image::make($this->file)->height();
  }

  /**
   * Upload the placeholder to the right directory
   */
  public function upload() {
    $this->file->move($this->baseDir(), $this->fileName());
    $this->makeThumbnail();

    return $this;
  }

  /**
   * Make the thumbnail image
    */
  public function makeThumbnail() {
    Image::make($this->filePath())->fit(200)->save($this->thumbnailPath());
  }
}
