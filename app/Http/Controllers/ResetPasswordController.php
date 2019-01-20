<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;

class ResetPasswordController extends Controller
{
    public function send_password_reset_link(Request $request){
        try{
            if(!$this->validate_email($request['email'])){
                return response()->json(['error'=> 'Sent email doesn\'t exists'], 403);
            }
            $this->send_email($request['email']);
            return response()->json(['message'=> 'please check your email account'], 200);
        } catch (\Exception $e){
            return response()->json([
                "message"=> $e->getMessage(),
                "line"=> $e->getLine(),
                "file"=> $e->getFile(),
            ], 500);
        }
    }
    public function validate_email($email){
        return !!User::where('email', $email)->first();
    }
    public function send_email($email){
        Mail::to($email)->send(new ResetPassword());
    }

}
