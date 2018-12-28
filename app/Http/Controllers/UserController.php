<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            return response()->json($user, 201);
        } catch (\Exception $e){
            return response()->json([
                "message"=> $e->getMessage(),
                "line"=> $e->getLine(),
                "file"=> $e->getFile(),
            ], 500);
        }
    }
}
