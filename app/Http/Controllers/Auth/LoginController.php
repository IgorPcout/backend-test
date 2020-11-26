<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class LoginController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set ( 'America/Sao_Paulo');
    }

    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();

        $auth = Auth::attempt($request->all());
        if($auth){
            $user = User::where('email', $request->email)->first();
            $signer = new Sha256();
            $time = time();
            $token = (new Builder())
                ->withClaim('uid', $user->id)
                ->expiresAt($time + 1800)
                ->getToken($signer, new Key(env('JWT_SECRET')));

            $now = date('Y-m-d H:i:s');

            $data = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ],
                'token' => (string) $token,
                'expiresAt' => date('Y-m-d H:i:s', strtotime($now . " + 1800 seconds"))
            ];

            return response()->json(['SUCCESS' => $data], 200);

        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'INVALID EMAIL OR PASSWORD']], 404);
        }
    }
}
