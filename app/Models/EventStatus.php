<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{
    protected $table = 'event_status';
    protected $fillable = ['id', 'value'];
    public $timestamps = false;
}
