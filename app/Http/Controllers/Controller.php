<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    public function __construct()
    {
        $user = Auth::user();
        if($user){
            $user_type = UserType::where('id', $user->user_type)->first();
            View::share('user_type', $user_type);
        }
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
