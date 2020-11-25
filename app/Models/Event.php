<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $appends = ['_links'];
    protected $fillable = ['id', 'user_id', 'event_name', 'date', 'street', 'number', 'neighborhood', 'state', 'city', 'event_status_id'];
    public $timestamps = false;

    public function getLinksAttribute()
    {
        return [
            'href' => route('event.show', ['id' => $this->id]),
            'rel' => 'Events'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function eventInvite()
    {
        return $this->hasMany(EventInvite::class, 'event_id');
    }

}
