<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationships
     */
    public function clubs() { return $this->belongsToMany('App\Club')->withTimestamps(); }

    /**
     * Can a user edit the current club
     *
     * @return boolean
     */
    public function canEdit($club) {
      $editor = Club::with('users')->find($club->id)->users->toArray();

      return in_array($this->id, array_flatten($editor));
    }

}
