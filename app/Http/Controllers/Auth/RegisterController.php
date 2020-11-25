<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'resume' => ['required', 'min:10'],
            'profile_picture' => ['required'],
            'city' => ['required'],
            'state' => ['required', 'max:2', 'min:2'],
        ])->validate();

        $user = $this->user->create([
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'resume' => strtoupper($request->resume),
            'city' => strtoupper($request->city),
            'state' => strtoupper($request->state)
        ]);

        $filename = $user->id.'.'.$request->profile_picture->extension();
        $image = $request->profile_picture->storeAs('profile_picture', $filename, 'public');

        $user->update([
            'profile_picture' => $filename
        ]);

        return response()->json(['SUCCESS' => ['MESSAGE' => 'USER SUCCESSFULLY REGISTERED']], 200);
    }
}
