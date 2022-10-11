<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class LoginBasic extends Controller
{
  public function index(Request $request)
  {
    return view('content.authentications.auth-login-basic');
  }


  public function authenticate(Request $request)
  {
    if(!$request->number || !$request->password){
      return redirect()->back()->withError('Both fields are required!')->withInput();
    }

    if(!Auth::attempt([
      'number' => $request->number,
      'password' => $request->password,
    ])){
      return redirect()->back()->withError('Invalid credentials')->withInput();
    }

    return redirect()->intended(route('dashboard'));
  }

  public function logout(Request $request){
    Auth::logout();
    return redirect('auth/login');
  }
}
