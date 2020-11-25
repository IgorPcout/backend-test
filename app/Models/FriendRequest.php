<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    protected $table = 'friend_request';
    public $timestamps = false;
    protected $fillable = ['id', 'user_id', 'email', 'status_id', 'new_member', 'date'];

    public function getRequestList($email)
    {
        $list = $this->where('email', $email)->where('status_id', 1)->get(['id','user_id', 'date']);

        $data = [];

        for ($i = 0; $i < count($list); $i++){
            $user = User::find($list[$i]->user_id);
            $data[$i] = ['id' => $list[$i]->id, 'name' => $user->name, 'date' => $list[$i]->date];
        }
        return $data;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
