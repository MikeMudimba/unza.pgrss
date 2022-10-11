<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Auth;

class Tutorials extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        if($user){
            $project = Project::where('student', $user->id)->first();
            return view('content.student.tutorials', [
                'project'=>$project,
            ]);
        }
    }
    
}
