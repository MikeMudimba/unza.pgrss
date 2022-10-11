<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programme;
use Auth;

class Programmes extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user){
            $projects = Programme::all();

            return view('content.user.view-projects', [
                'user'=>$user,
                'projects'=>$projects,
            ]);

        }
    }
}
