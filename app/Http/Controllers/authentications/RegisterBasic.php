<?php

namespace App\Http\Controllers\authentications;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class RegisterBasic extends Controller
{
  public function index()
  {
    $user_types = DB::table('user_type')->orderBy('name')->get();
    $schools = DB::table('school')->orderBy('name')->get();
    $departments = DB::table('department')->orderBy('name')->get();
    return view(
      'content.authentications.auth-register-basic', 
      [
        'user_types' => $user_types,
        'schools' => $schools,
        'departments' => $departments,
      ]);
  }

  public function signup(Request $request)
  {
    $id = trim($request->id);
    $firstName = trim($request->first_name);
    $lastName = trim($request->sur_name);
    $mobile = trim($request->phone);
    $email = trim($request->email);
    $department = $request->department;
    $school = $request->school;
    $type = $request->type;
    $password = $request->password;
    $confirmPassword = $request->confirmPassword;

    if (!$id || !$firstName || !$lastName || !$mobile ||  !$email || !$type || !$password || !$confirmPassword || !$department   || !$school ) {
        return redirect()->back()->withError('Fill in all the required fields!')->withInput();
    }

    if ($password != $confirmPassword) {
        return redirect()->back()->withError('Passwords do not match!')->withInput();
    }

    if (preg_match('/[^0-9]/', $mobile)) {
        return redirect()->back()->withError('Invalid mobile number!')->withInput();
    }

    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return redirect()->back()->withError('Invalid email address!')->withInput();
    }


    $existingUser = User::where('number', $id)->first();

    if ($existingUser) {
        return redirect()->back()->withError('A user with User ID "' . $id . '" already exists!')->withInput();
    }


    DB::beginTransaction();

    try {

        $newUser = new User();

        $newUser->number = $id;
        $newUser->first_name = $firstName;
        $newUser->last_name = $lastName;
        $newUser->phone = $mobile;
        $newUser->email = $email;
        $newUser->department = $department;
        $newUser->school = $school;
        $newUser->user_type = $type;
        $newUser->password = Hash::make($password);
        $newUser->created_at = date('Y-m-d H:i:s');
        $newUser->status = '1';
        
        $newUser->save();

        DB::commit();

        return redirect()->route('login')->withSuccess('Account created successfully')->withInput();
    } catch (Exception $e) {
        DB::rollback();

        return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
    }
  }
} 
