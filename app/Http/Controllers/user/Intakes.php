<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intake;
use Auth;

class Intakes extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user){
            $projects = Intake::all();

            return view('content.user.view-projects', [
                'user'=>$user,
                'projects'=>$projects,
            ]);

        }
    }
}
