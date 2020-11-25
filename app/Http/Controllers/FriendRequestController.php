<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationRequestMail;
use App\Models\FriendList;
use App\Models\FriendRequest;
use App\Models\User;
use App\Utils\JwtValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FriendRequestController extends Controller
{
    private $friend;

    public function __construct(FriendRequest $friend)
    {
        $this->friend = $friend;
        date_default_timezone_set ( 'America/Sao_Paulo');
    }

    public function newFriendRequest($id, Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['email', 'required']
        ])->validate();

        $user = User::find($id);
        if($user){
            if((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER DOES NOT HAVE AUTHORIZATION TO USE THIS FUNCTION']], 403);
            }

            $target = User::where('email', $request->email)->first();
            if($target){

                if((new FriendList())->existingFriendship($user->id, $target->id)){
                    return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER IS ALREADY YOUR FRIEND']], 400);
                }

                $friend = $this->friend->create([
                    'user_id' => $user->id,
                    'email' => $target->email,
                    'status_id' => 1,
                    'new_member' => 0,
                    'date' => date('Y-m-d')
                ]);

                $mail = Mail::to($request->email)->send(new \App\Mail\FriendRequest($user));

                return response()->json(['SUCCESS' => ['MESSAGE' => 'YOUR FRIENDSHIP REQUEST WAS SENT TO '.$target->name]], 200);
            }else{
                $friend = $this->friend->create([
                    'user_id' => $user->id,
                    'email' => $request->email,
                    'status_id' => 1,
                    'new_member' => 1,
                    'date' => date('Y-m-d')
                ]);

                $mail = Mail::to($request->email)->send(new \App\Mail\NewUserFriendRequest($user));

                return response()->json(['SUCCESS' => ['MESSAGE' => 'YOUR FRIENDSHIP REQUEST WAS SENT TO '.$request->email]], 200);
            }

        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function show($id, Request $request)
    {
        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }
            $request = $this->friend->getRequestList($user->email);
            return response()->json(['SUCCESS' => $request], 200);
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function reject($id, Request $request)
    {
        Validator::make($request->all(), [
            'friend_request_id' => 'required'
        ])->validate();

        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }
            $friend = $this->friend->find($request->friend_request_id);
            if($friend){

                if($friend->status_id != 1){
                    return response()->json(['ERROR' => ['MESSAGE' => 'YOU CANNOT REJECT THIS REQUEST']], 400);
                }

                if($user->email != $friend->email){
                    return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS DATA']], 403);
                }

                $action = $friend->update([
                    'status_id' => 3
                ]);

                if($action){
                    return response()->json(['SUCCESS' => ['MESSAGE' => 'FRIENDSHIP REQUEST REJECTED']], 200);
                }else{
                    return response()->json(['ERROR' => ['MESSAGE' => 'THERE WAS AN ERROR WHEN REJECTING FRIENDSHIP REQUEST']], 400);
                }

            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'FRIEND REQUEST NOT FOUND']], 404);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function accept($id, Request $request)
    {
        Validator::make($request->all(), [
            'friend_request_id' => 'required'
        ])->validate();

        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }
            $req = $this->friend->find($request->friend_request_id);
            if($req){

                if($user->email != $req->email){
                    return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS DATA']], 403);
                }

                if($req->status_id != 1){
                    return response()->json(['ERROR' => ['MESSAGE' => 'YOU CANNOT ACCEPT THIS REQUEST']], 400);
                }

                $action = $req->update([
                    'status_id' => 2
                ]);

                if($action){

                    $one = FriendList::create([
                        'friend_id' => $req->user_id,
                        'user_id' => $user->id
                    ]);

                    $two = FriendList::create([
                        'friend_id' => $user->id,
                        'user_id' => $req->user_id
                    ]);

                    if($one && $two){
                        return response()->json(['SUCCESS' => ['MESSAGE' => 'FRIENDSHIP REQUEST ACCEPTED']], 200);
                    }else{
                        return response()->json(['ERROR' => ['MESSAGE' => 'THERE WAS AN ERROR WHEN REJECTING FRIENDSHIP REQUEST']], 400);
                    }
                }else{
                    return response()->json(['ERROR' => ['MESSAGE' => 'THERE WAS AN ERROR WHEN REJECTING FRIENDSHIP REQUEST']], 400);
                }

            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'FRIEND REQUEST NOT FOUND']], 404);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }
}
