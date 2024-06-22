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
            $response = [
                "token" => null,
            ];
            
            $token = $user->createToken($request->email, ['user'])->plainTextToken;
            $response["token"] = $token;

            if($token) {
                return APIFormatter::createAPI(200, "Success", $response);
            } else {
                return APIFormatter::createAPI(400, 'Failed', $response);
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Error', $e);
        }
    }

    public function signIn(Request $request) {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $user = User::where('email', $request->email)->first();
            $response = [
                "token" => null,
            ];
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return APIFormatter::createAPI(422, 'Email atau kata sandi salah.', $response);
            } else {
                $token = $user->createToken($request->email, ['user'])->plainTextToken;
                $response["token"] = $token;
    
                if($token) {
                    return APIFormatter::createAPI(200, "Success", $response);
                } else {
                    return APIFormatter::createAPI(400, 'Failed', $response);
                }
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }

    public function signOut(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $pipePosition = strpos($token, '|');
            $tokenId = substr($token, 0, $pipePosition);

            $deleted = DB::delete("delete from personal_access_tokens where id = '$tokenId'");

            if($deleted) {
                return APIFormatter::createAPI(200, 'Success', true);
            } else {
                return APIFormatter::createAPI(400, 'Failed', false);
            }
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(500, 'Gagal keluar', $th);
        }
    }
}
