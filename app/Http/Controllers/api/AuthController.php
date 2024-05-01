<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string',
                'gender_id' => 'required',
            ]);

            $userInput = $request->all();
            $userInput['password'] = Hash::make($request->password);
            $user = User::create($userInput);
            
            $token = $user->createToken($request->email, ['user'])->plainTextToken;

            if($token) {
                return APIFormatter::createAPI(200, "Success", $token);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }

    public function signIn(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $user = User::where('email', $request->email)->first();
    
            if (!$user && !Hash::check($request->password, $user->password)) {
                return APIFormatter::createAPI(422, 'Email atau kata sandi salah.');
            } else {
                $token = $user->createToken($request->email, ['user'])->plainTextToken;
    
                if($token) {
                    return APIFormatter::createAPI(200, "Success", $token);
                } else {
                    return APIFormatter::createAPI(400, 'Failed');
                }
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }

    public function signOut($tokenId)
    {
        try {
            $data = DB::delete("delete from personal_access_tokens where id = '$tokenId'");

            if($data) {
                return APIFormatter::createAPI(200, 'Berhasil logout', true);
            } else {
                return APIFormatter::createAPI(400, 'Failed', false);
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }
}
