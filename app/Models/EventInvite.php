<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventInvite extends Model
{
    protected $table = 'event_invite';
    protected $fillable = ['id', 'event_id', 'user_id', 'status_id'];
    public $timestamps = false;

    public function alreadyInvited($event_id, $id)
    {
        $event = $this->where('event_id', $event_id)->where('user_id', $id)->first();
        if($event){
            return true;
        }else{
            return false;
        }
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'status_id');
    }
}
