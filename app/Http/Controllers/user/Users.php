<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class Users extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user){
            $projects = User::all();

            return view('content.user.view-projects', [
                'user'=>$user,
                'projects'=>$projects,
            ]);

        }
    }
}
