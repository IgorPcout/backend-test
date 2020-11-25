<?php


namespace App\Utils;

use App\Models\Adm;
use App\Models\UserAccount;
use App\Utils\Message;
use App\Models\User;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;

class JwtValidation
{

    public function getPayload(Request $request)
    {
        $fields = explode(' ', $request->header('Authorization'));
        $token = explode('.', $fields[1]);
        $payload = base64_decode($token[1]);
        $payload = json_decode($payload);
        return $payload;
    }

    public function validate($id, Request $request)
    {
        $token = $this->getPayload($request);
        if ($token->uid != $id) {
            return false;
        }else {
            return true;
        }
    }
}
