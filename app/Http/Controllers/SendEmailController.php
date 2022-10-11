<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
use Mail;
 
use App\Mail\NotifyMail;
 
 
class SendEmailController extends Controller
{
     
    public function index(Request $request)
    {
     Mail::to($request->email)->send(new NotifyMail());
 
     if (Mail::failures()) {
          return redirect()->route('auth-change-password')->withSuccess('Account not found')->withInput();
     }else{
          return redirect()->route('auth-reset-password')->withError('Account not found')->withInput();
     }
    } 
}