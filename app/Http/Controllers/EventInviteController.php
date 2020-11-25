<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventInvite;
use App\Models\FriendList;
use App\Models\User;
use App\Utils\JwtValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\json_decode;

class EventInviteController extends Controller
{
    private $invite;

    public function __construct(EventInvite $invite)
    {
        $this->invite = $invite;
        date_default_timezone_set ( 'America/Sao_Paulo');
    }

    public function invite(Request $request)
    {
        Validator::make($request->all(), [
            'event_id' => 'required'
        ])->validate();

        $event = Event::find($request->event_id);
        if($event){
            if ((new JwtValidation())->validate($event->user_id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            if($event->event_status_id != 1){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS EVENT IS ALREADY OVER OR CANCELED']], 400);
            }

            $now = date('Y-m-d H:i:s');
            if(strtotime($event->date) < strtotime($now)){
                if($event->event_status_id != 2){
                    $event->update(['event_status_id' => 2]);
                }
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS EVENT HAS ALREADY HAPPENED']], 400);
            }

            if (!$request->has('friends') || $request->friends == null || $request->friends == ''){
                $friendList = (new FriendList())->getFriendList($event->user_id);
                for ($i = 0; $i < count($friendList); $i++){
                    $verifyUser = User::find($friendList[$i]['user_id']);
                    if($verifyUser){
                        $alreadyInvited = $this->invite->alreadyInvited($event->id, $friendList[$i]['user_id']);
                        if($alreadyInvited == false){
                            $invite = $this->invite->create([
                                'event_id' => $event->id,
                                'user_id' => $friendList[$i]['user_id'],
                                'status_id' => 1
                            ]);
                            if($invite){
                                $user = User::find($invite->user_id);
                                $owner = User::find($event->user_id);
                                $data = [
                                    'name' => $user->name,
                                    'owner' => $owner->name,
                                    'event_name' => $event->event_name,
                                    'event_date' => $event->date,
                                    'event_city' => $event->city,
                                    'event_state' => $event->state
                                ];
                                $mail = Mail::to($user->email)->send(new \App\Mail\EventInvite($data));
                            }
                        }
                    }
                }
                return response()->json(['SUCCESS' => ['MESSAGE' => 'THE INVITATION WAS SENT TO ALL YOUR FRIENDS']], 200);
            }
            elseif ($request->has('friends')){
                $friends = json_decode($request->friends);
                if(is_array($friends)){
                    foreach ($friends as $friend){
                        if((new FriendList())->existingFriendship($event->user_id, $friend) == true) {
                            $verifyUser = User::find($friend);
                            if($verifyUser){
                                $alreadyInvited = $this->invite->alreadyInvited($event->id, $friend);
                                if ($alreadyInvited == false) {
                                    $invite = $this->invite->create([
                                        'event_id' => $event->id,
                                        'user_id' => $friend,
                                        'status_id' => 1
                                    ]);
                                    if ($invite) {
                                        $user = User::find($invite->user_id);
                                        $owner = User::find($event->user_id);
                                        $data = [
                                            'name' => $user->name,
                                            'owner' => $owner->name,
                                            'event_name' => $event->event_name,
                                            'event_date' => $event->date,
                                            'event_city' => $event->city,
                                            'event_state' => $event->state
                                        ];

                                        $mail = Mail::to($user->email)->send(new \App\Mail\EventInvite($data));
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $verifyUser = User::find($friends);
                    if($verifyUser){
                        if((new FriendList())->existingFriendship($event->user_id, $friends) == true) {
                            $alreadyInvited = $this->invite->alreadyInvited($event->id, $friends);
                            if ($alreadyInvited == false) {
                                $invite = $this->invite->create([
                                    'event_id' => $event->id,
                                    'user_id' => $friends,
                                    'status_id' => 1
                                ]);
                                if ($invite) {
                                    $user = User::find($invite->user_id);
                                    $owner = User::find($event->user_id);
                                    $data = [
                                        'name' => $user->name,
                                        'owner' => $owner->name,
                                        'event_name' => $event->event_name,
                                        'event_date' => $event->date,
                                        'event_city' => $event->city,
                                        'event_state' => $event->state
                                    ];
                                    $mail = Mail::to($user->email)->send(new \App\Mail\EventInvite($data));
                                }
                            }else{
                                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER IS ALREADY INVITED']], 400);
                            }
                        }else{
                            return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER IS NOT YOUR FRIEND']], 400);
                        }
                    }else{
                        return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
                    }
                }
                return response()->json(['SUCCESS' => ['MESSAGE' => 'THE INVITATION WAS SENT TO YOUR FRIENDS']], 200);
            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'SOMETHING HAPPENED']], 400);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'EVENT NOT FOUND']], 404);
        }
    }

    public function myInvites($id, Request $request)
    {

        /**
         *
         * ?status=1
         * filterName=value
         *
         */

        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $query = EventInvite::query();

            if($request->has('status') && $request->status != '' && $request->status != null){
                $query->where('status_id', $request->status);
            }

            $result = $query->leftJoin('event', 'event_invite.event_id', '=', 'event.id')
                            ->leftJoin('users', 'event_invite.user_id', '=', 'users.id')
                            ->leftJoin('status', 'event_invite.status_id', '=', 'status.id')
                            ->select('event_invite.id as id', 'event.event_name', 'users.name', 'status.value as status')
                            ->where('event_invite.user_id', $user->id)
                            ->get();

            return response()->json(['SUCCESS' => ['DATA' => $result]], 200);

        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function action(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'invite_id' => 'required',
            'action' => 'required'
        ])->validate();

        $user = User::find($request->user_id);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }
            $invite = $this->invite->find($request->invite_id);
            if($invite){
                $event = Event::find($invite->event_id);
                if($event) {
                    $now = date('Y-m-d H:i:s');
                    if (strtotime($event->date) < strtotime($now)) {
                        if ($event->event_status_id != 2) {
                            $event->update(['event_status_id' => 2]);
                        }
                        return response()->json(['ERROR' => ['MESSAGE' => 'THIS EVENT HAS ALREADY HAPPENED']], 400);
                    }
                    if($request->action == 2 || $request->action == 3){
                        $updated = $invite->update(['status_id' => $request->action]);
                        if($updated){
                            return response()->json(['SUCCESS' => ['MESSAGE' => 'DONE']], 200);
                        }else{
                            return response()->json(['ERROR' => ['MESSAGE' => 'ERROR OCCURRED UPDATING INVITATION DATA']], 400);
                        }
                    }else{
                        return response()->json(['ERROR' => ['MESSAGE' => 'INVALID ACTION']], 400);
                    }
                }else{
                    return response()->json(['ERROR' => ['MESSAGE' => 'EVENT NOT FOUND']], 404);
                }
            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'INVITE NOT FOUND']], 404);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }
}
