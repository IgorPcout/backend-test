<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendList extends Model
{
    protected $table = 'FRIEND_LIST';
    protected $fillable = ['id', 'user_id', 'friend_id'];
    public $timestamps = false;

    public function existingFriendship($id, $friendId)
    {
        $one = $this->where('user_id', $id)->where('friend_id', $friendId)->first();
        $two = $this->where('user_id', $friendId)->where('friend_id', $id)->first();

        if($one || $two){
            return true;
        }else{
            return false;
        }
    }

    public function getFriendList($id)
    {
        $list = $this->where('user_id', $id)->get('friend_id');
        $data = [];
        foreach ($list as $key => $friend){
            $user = User::find($friend->friend_id);
            $data[$key] = ['user_id' => $user->id, 'name' => $user->name];
        }
        return $data;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
