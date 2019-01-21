<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    public function change_password(ChangePasswordRequest $request){

        $token_exists = $this->get_password_reset_table_row($request)->first();
        if($token_exists){
            return $this->update_password($request);
        }
        else{
            return response()->json(['error'=> 'Token or email is incorrect'], 400);
        }
    }
    public function get_password_reset_table_row($request){
        return DB::table('password_resets')->where(['email'=> $request->email, 'token'=> $request->reset_token]);
    }

    public function update_password($request){
        $user = User::whereEmail($request->email)->first();
        $user->update(['password'=> $request->password]);
        $this->get_password_reset_table_row($request)->delete();
        return response()->json(['data'=> 'Password Successfully Changed!'], 200);
    }
}
