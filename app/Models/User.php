<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'resume', 'profile_picture', 'city', 'state'
    ];

    protected $hidden = [
        'password'
    ];

    public $timestamps = false;


    public function friendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'user_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

}
