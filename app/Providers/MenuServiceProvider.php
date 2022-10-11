<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    view()->composer('*', function($view)
    {
        if (Auth::check()) {
          $user = Auth::user();
          $type = $user->user_type;
          $user_type = DB::table('user_type')->select(['name'])->where('id', $type)->get();
          
          $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
          $verticalMenuData = json_decode($verticalMenuJson);
          
          //return array
          $return = array(
            'userType' => $user_type,
            'menuData' => $verticalMenuData,
            'User'=>$user,
          );
          // Share all menuData to all the views
          \View::share('menuDetails', [$return]);
        }
    });
    
  }
}
