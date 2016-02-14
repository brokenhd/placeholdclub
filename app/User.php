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
    public function clubs() { return $this->hasMany('App\Club'); }

    /**
     * What does a user own
     */
    public function owns($relation) {
      return $relation->user_id == $this->id;
    }

}
