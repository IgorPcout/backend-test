<?php

namespace App\Http\Controllers;

use App\Models\FriendList;
use App\Models\User;
use App\Utils\JwtValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendListController extends Controller
{
    private $friend;

    public function __construct(FriendList $friend)
    {
        $this->friend = $friend;
    }

    public function show($id, Request $request)
    {
        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $friendList = $this->friend->getFriendList($user->id);
            return response()->json(['SUCCESS' => $friendList], 200);
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function removeFriend($id, Request $request)
    {

        Validator::make($request->all(), [
            'friend_id' => 'required'
        ])->validate();

        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $friend = User::find($request->friend_id);
            if($friend){
                $friendship = $this->friend->existingFriendship($user->id, $friend->id);
                if($friendship){
                    $one = $this->friend->where('user_id', $user->id)->where('friend_id', $friend->id)->get();
                    $two = $this->friend->where('user_id', $friend->id)->where('friend_id', $user->id)->get();
                    foreach ($one as $value){
                        $value->delete();
                    }
                    foreach ($two as $value){
                        $value->delete();
                    }

                    return response()->json(['SUCCESS' => ['MESSAGE' => 'FRIENDSHIP SUCCESSFULLY REMOVED']], 200);

                }else{
                    return response()->json(['ERROR' => ['MESSAGE' => 'USERS ARE NOT FRIENDS']], 400);
                }
            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }
}
