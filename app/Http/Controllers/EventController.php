<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventInvite;
use App\Models\User;
use App\Utils\JwtValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        date_default_timezone_set ( 'America/Sao_Paulo');
    }

    public function index(Request $request)
    {
        /**
         *
         * ?dateStart=>=:2020-11-25&dateEnd=<=:2020-11-30&state==:MG
         * filterName=operation:value
         *
         */

        $query = Event::query();
        if($request->has('dateStart')){
            $res = explode(':', $request->dateStart.' 00:00:00');
            $query->where('date', $res[0], $res[1]);
        }

        if ($request->has('dateEnd')){
            $res = explode(':', $request->dateEnd.' 23:59:00');
            $query->where('date', $res[0], $res[1]);
        }

        if($request->has('state')){
            $res = explode(':', $request->state);
            $query->where('state', $res[0], $res[1]);
        }

        $result = $query->leftJoin('event_status', 'event.event_status_id', '=', 'event_status.id')
                        ->select('event.id', 'event.event_name', 'event_status.value as status')
                        ->paginate(10);
        return response()->json(['SUCCESS' => ['DATA' => $result]], 200);
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'event_name' => 'required',
            'date' => ['required', 'date'],
            'street' => 'required',
            'number' => 'required',
            'city' => 'required',
            'neighborhood' => 'required',
            'state' => ['required', 'max:2', 'min:2']
        ])->validate();

        $date = explode(' ', $request->date);
        $now = date('Y-m-d H:i:s');
        if(strtotime($request->date) < strtotime($now)){
            return response()->json(['ERROR' => ['MESSAGE' => 'INVALID DATE']], 400);
        }
        if(count($date) != 2){
            return response()->json(['ERROR' => ['MESSAGE' => 'INVALID DATE. THIS FIELD ACCEPT: ex 2020-11-23 19:45:00 (Y-m-d H:i:s)']], 400);
        }

        $user = User::find($request->user_id);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $event = $this->event->create([
                'user_id' => $user->id,
                'event_name' => strtoupper($request->event_name),
                'date' => strtoupper($request->date),
                'street' => strtoupper($request->street),
                'number' => strtoupper($request->number),
                'city' => strtoupper($request->city),
                'neighborhood' => strtoupper($request->neighborhood),
                'state' => strtoupper($request->state),
                'event_status_id' => 1
            ]);

            if($event){
                return response()->json(['SUCCESS' => ['MESSAGE' => 'EVENT SUCCESSFULLY CREATED']], 200);
            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'THERE WAS AN ERROR WHEN CREATING A EVENT']], 400);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function show($id)
    {
        $event = $this->event->find($id);
        if($event){
            $events = DB::table('event')
                ->where('event.id', '=', $id)
                ->leftJoin('users', 'event.user_id', '=', 'users.id')
                ->leftJoin('event_status', 'event.event_status_id', '=', 'event_status.id')
                ->get(['event.id', 'users.name as owner', 'event.event_name', 'event.street', 'event.number', 'event.neighborhood', 'event.state', 'event.city', 'event.date', 'event_status.value as status']);
            return response()->json(['SUCCESS' => $events], 200);
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'EVENT NOT FOUND']], 404);
        }
    }

    public function myEvents($id, Request $request)
    {
        $user = User::find($id);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $events = DB::table('event')
                                            ->leftJoin('users', 'event.user_id', '=', 'users.id')
                                            ->leftJoin('event_status', 'event.event_status_id', '=', 'event_status.id')
                                            ->get(['event.id', 'users.name as owner', 'event.event_name', 'event.street', 'event.number', 'event.neighborhood', 'event.state', 'event.city', 'event.date', 'event_status.value as status']);
            foreach ($events as $event){
                $event->member_list = [
                    'href' => route('event.memberList', ['id' => $event->id]),
                    'available_filters' => 'status'
                ];
            }
            return response()->json(['SUCCESS' => $events], 200);
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function update($userId, $eventId, Request $request)
    {
        $user = User::find($userId);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            if($request->has('user_id')){
                return response()->json(['ERROR' => ['MESSAGE' => 'user_id FIELD CANNOT BE CHANGED']], 400);
            }

            if($request->has('event_status_id')){
                return response()->json(['ERROR' => ['MESSAGE' => 'event_status_id FIELD CANNOT BE CHANGED FOR THIS WAY']], 400);
            }

            if ($request->has('date')){
                $now = date('Y-m-d H:i:s');
                if(strtotime($request->date) < strtotime($now)){
                    return response()->json(['ERROR' => ['MESSAGE' => 'INVALID DATE']], 400);
                }
                $date = explode(' ', $request->date);
                if(count($date) != 2){
                    return response()->json(['ERROR' => ['MESSAGE' => 'INVALID DATE. THIS FIELD ACCEPT: ex 2020-11-23 19:45:00 (Y-m-d H:i:s)']], 400);
                }
            }

            $event = $this->event->find($eventId);
            if($event){

                if($event->user_id != $user->id){
                    return response()->json(['ERROR' => ['MESSAGE' => 'YOU ATE NOT THE OWNER OF THIS EVENT']], 400);
                }

                $data = [];

                foreach ($request->all() as $key => $value){
                    $data += [$key => strtoupper($value)];
                }

                $updated = $event->update($data);
                if($updated){
                    return response()->json(['SUCCESS' => ['MESSAGE' => 'EVENT SUCCESSFULLY UPDATED']], 200);
                }else{
                    return response()->json(['ERROR' => ['MESSAGE' => 'THERE WAS AN ERROR WHEN UPDATING THE EVENT']], 400);
                }
            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'EVENT NOT FOUND']], 404);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function cancel($userId, $eventId, Request $request)
    {
        $user = User::find($userId);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $event = $this->event->find($eventId);
            if($event){

                if($event->user_id != $user->id){
                    return response()->json(['ERROR' => ['MESSAGE' => 'YOU ATE NOT THE OWNER OF THIS EVENT']], 400);
                }

                $updated = $event->update(['event_status_id' => 3]);
                if($updated){
                    return response()->json(['SUCCESS' => ['MESSAGE' => 'EVENT SUCCESSFULLY CANCELED']], 200);
                }else{
                    return response()->json(['ERROR' => ['MESSAGE' => 'THERE WAS AN ERROR WHEN CANCELING THE EVENT']], 400);
                }
            }else{
                return response()->json(['ERROR' => ['MESSAGE' => 'EVENT NOT FOUND']], 404);
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function getEventMemberList($id, Request $request)
    {
        /**
         *
         * ?status=1
         * filterName=value
         *
         */

        $event = $this->event->find($id);
        if($event){
            if ((new JwtValidation())->validate($event->user_id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }
            $query = EventInvite::query();

            $query->where('event_id', $id);

            if($request->has('status') && $request->status != '' && $request->status != null){
                $query->where('status_id', $request->status);
            }

            $result = $query->leftJoin('event', 'event_invite.event_id', '=', 'event.id')
                            ->leftJoin('users', 'event_invite.user_id', '=', 'users.id')
                            ->leftJoin('status', 'event_invite.status_id', '=', 'status.id')
                            ->select('event_invite.id as id', 'event.event_name', 'users.name', 'status.value as status')
                            ->get();
            return response()->json(['SUCCESS' => ['DATA' => $result]], 200);
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'EVENT NOT FOUND']], 404);
        }
    }
}
