<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use DB;

class ForgotPasswordBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-forgot-password-basic');
  }

  function reset(Request $request)
  {
    $user = DB::table('user')->where('number', $request->id)->first();
    
    if($user){
      return redirect()->route('send-email', ['email' => $user->email,])->withSuccess('Password reset email sent to $email')->withInput();
    }else{
      return redirect()->route('auth-reset-password')->withError('Account not found')->withInput();
    }
    

  }
}

