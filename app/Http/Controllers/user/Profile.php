<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Project;
use App\Models\UserType;
use App\Models\School;
use App\Models\Department;
use App\Models\Status;
use App\Models\User;

class Profile extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $department = Department::where('school', $user->school)->get();
    $school = School::all();
    $status = Status::where('id', $user->status)->first();
    $user_type = UserType::where('id', $user->user_type)->first();

    if($user){
      return view('content.user.profile', [
        'user'=>$user,
        'status'=>$status,
        'schools'=>$school,
        'departments'=>$department,
        'userType'=>$user_type,
      ]);
    }
  }


  public function settings()
    {
      $user = Auth::user();
      $department = Department::where('school', $user->school)->get();
      $school = School::all();
      $status = Status::where('id', $user->status)->first();
      $user_type = UserType::where('id', $user->user_type)->first();
  
      if($user){
        return view('content.user.settings', [
          'user'=>$user,
          'status'=>$status,
          'schools'=>$school,
          'departments'=>$department,
          'userType'=>$user_type,
        ]);
      }
    }



  public function update(Request $request)
  {
    $user = Auth::user();
    $department = Department::where('school', $user->school)->get();
    $school = School::all();
    $status = Status::where('id', $user->status)->first();
    $user_type = UserType::where('id', $user->user_type)->first();

    if($request->first_name){
      User::where('id',$user->id)->update(['first_name'=>$request->first_name]);
    }
    if($request->last_name){
      User::where('id',$user->id)->update(['last_name'=>$request->last_name]);
    }
    if($request->phone){
      User::where('id',$user->id)->update(['phone'=>$request->phone]);
    }
    if($request->email){
      User::where('id',$user->id)->update(['email'=>$request->email]);
    }
    if($request->school){
      User::where('id',$user->id)->update(['school'=>$request->school]);
    }
    if($request->department){
      User::where('id',$user->id)->update(['department'=>$request->department]);
    }

    $date = date('U');
    $destinationPath = 'public/assets/img/avaters/';
    
    if($request->profilephoto){
      $name = $date.$user->email.'.'.$request->file("profilephoto")->extension();
      if($request->file('profilephoto')->storeAs($destinationPath,  "$name")){
        User::where('id',$user->id)->update(['avater'=>$name]);
      }
    }
    

    return redirect()->intended(route('account-profile'))->withSuccess('Changes made successfully')->withInput();

  }

  public function delete(Request $request)
  {
    $user = Auth::user();
    
    if($user){
        //update start
        if($request->accountDeactivation){
            if(User::where('id', $user->id)->delete()){
                return redirect()->intended(route('logout'))->withSuccess('Your account has been permanently deleted.')->withInput();
            }
        }
    }
  }
}
