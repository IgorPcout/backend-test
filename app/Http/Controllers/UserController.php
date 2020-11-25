<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\JwtValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile($id, Request $request)
    {
        $user = $this->user->find($id);
        if($user){
            if ((new JwtValidation())->validate($user->id, $request) == false){
                return response()->json(['ERROR' => ['MESSAGE' => 'THIS USER CANNOT ACCESS THIS FUNCTION']], 403);
            }

            $data = $user->makeHidden('profile_picture');
            $data->picture = [
                'base64_image' => $this->profilePicture($user->id)
            ];
            return response()->json(['SUCCESS' => ['DATA' => $data]], 200);

        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }

    public function profilePicture($id)
    {
        $user = $this->user->find($id);
        if($user){
            $name = "profile_picture/{$user->profile_picture}";
            if(Storage::disk('public')->exists($name)){
                $path = Storage::disk('public')->path($name);
                $file = file_get_contents($path);
                $file = base64_encode($file);
                $ext = explode('.', $name);
                $ext = $ext[1];
                if($ext === 'pdf'){
                    $file = 'data:application/' . $ext . ';base64,' . $file;
                }else{
                    $file = 'data:image/' . $ext . ';base64,' . $file;
                }
                return $file;
            }else{
                $user->update(['profile_picture' => null]);
                return "PROFILE PICTURE NOT FOUND";
            }
        }else{
            return response()->json(['ERROR' => ['MESSAGE' => 'USER NOT FOUND']], 404);
        }
    }
}
