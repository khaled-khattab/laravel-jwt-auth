<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "name"=> "required|string",
                "email"=> "required|email|unique:users",
                "password"=> "required|string"
            ]);
            if($validator->fails())
                return response()->json($validator->errors(), 400);
            $request['password'] = bcrypt($request['password']);
            $user = User::create($request->all());
            $user['token'] = JWTAuth::fromUser($user);
            return response()->json($user, 201);
        } catch (\Exception $e){
            return response()->json([
                "message"=> $e->getMessage(),
                "line"=> $e->getLine(),
                "file"=> $e->getFile(),
            ], 500);
        }
    }
    public function login(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "email"=> "required|email",
                "password"=> "required|string"
            ]);
            if($validator->fails())
                return response()->json($validator->errors(), 400);
            $credentials = $request->only('email', 'password');
            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            return response()->json(['token'=> $token], 200);
        } catch (\Exception $e){
            return response()->json([
                "message"=> $e->getMessage(),
                "line"=> $e->getLine(),
                "file"=> $e->getFile(),
            ], 500);
        }
    }
    public function me(Request $request){
        return auth()->user();
    }
}
