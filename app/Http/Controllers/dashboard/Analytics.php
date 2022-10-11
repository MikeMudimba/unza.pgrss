<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Project;
use App\Models\UserType;
use App\Models\ProjectAttachment;
use App\Models\Programme;
use App\Models\School;
use App\Models\Department;
use App\Models\Intake;
use App\Models\Status;
use App\Models\Comment;
use App\Models\User;

class Analytics extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $userStatus = Status::where('id', $user->status)->first();

    $user_type = UserType::where('id', $user->user_type)->first();

    if($user_type->name == "Student"){
      $project = Project::where('student', $user->id)->first();
      if($project){
        $stage = $project->stage;
      }else{
        $stage = 0;
      }
      $stage_ = $stage;

      if($project){
        $school = School::where('id', $project->school)->first();
        $department = Department::where('id', $project->department)->first();
        $programme = Programme::where('id', $project->programme)->first();
        $intake = Intake::where('id', $project->intake)->first();
        $status = Status::where('id', $project->status)->first();
        $comments = Comment::where('project', $project->id)->where('stage', $project->stage)->get();
        $supervisor = User::where('id', $project->supervisor)->first();
        if(!$supervisor){
          $supervisor = (object)array("id"=>0, "name"=>"Not assigned", "phone"=>"None", "email"=>"None");
        }
      }else{
        $school = (object)array("name"=>"Note set");
        $department = (object)array("name"=>"Note set");
        $programme = (object)array("name"=>"Note set");
        $intake = (object)array("name"=>"Note set");
        $supervisor = (object)array("id"=>0, "name"=>"Not assigned", "phone"=>"None", "email"=>"None");
        $comments = array();
        $status = (object)array("name"=>"Note set", "color"=>"warning");
        $project = (object)array("name"=>"You have not yet registered. Click Get started above to register your research.");
      }
      

      

      $progress = intval(($stage/7)*100);
      if($progress <= 0){$greeting = "Hello, ";}else{$greeting="Congratulations, ";}
      $remaining_progress = intval(100-$progress);

      if($stage < 1){
        $next = "Get started";
        $route= "student-register";
        $router= "student-register";
        $stage="New user";
      }elseif($stage == 1){
        $next = "Submit ethical clearance";
        $route= "student-ethical-clearance";
        $stage="Registration poimt of user";
        $router= "student-register";
      }elseif($stage == 2){
        $next = "Submit research proposal";
        $route= "student-research-proposal";
        $router= "student-ethical-clearance";
        $stage="Ethical clearance";
      }elseif($stage == 3){
        $next = "Seminer week";
        $route= "student-seminer-week";
        $router= "student-research-proposal";
        $stage="Research proposal";
      }elseif($stage == 4){
        $next = "Submit dissertation";
        $router= "student-seminer-week";
        $route= "student-dissertation";
        $stage="Seminer week";
      }elseif($stage == 5){
        $next = "Submit journal";
        $route= "student-journal";
        $router= "student-dissertation";
        $stage="Dissertation";
      }elseif($stage == 6){
        $next = "Get completion letter";
        $router= "student-journal";
        $route= "student-completion-letter";
        $stage="Journal paper";
      }else{
        $next = "View completion letter";
        $router= "student-completion-letter";
        $route= "student-completion-letter";
        $stage="Completion letter";
      }

  
      if($user){
        return view('content.dashboard.dashboards-analytics', [
          'user'=>$user,
          'greeting'=>$greeting,
          'progress'=>$progress,
          'next'=>$next,
          'route'=>$route,
          'remaining_progress'=>$remaining_progress,
          'user_type'=>$user_type,
          'project'=>$project,
          'programme'=>$programme,
          'school'=>$school,
          'department'=>$department,
          'intake'=>$intake,
          'status'=>$status,
          'userStatus'=>$userStatus,
          'comments'=>$comments,
          'stage'=>$stage,
          'stage_'=>$stage_,
          'router'=>$router,
          'supervisor'=>$supervisor,
        ]);
      }
    }elseif($user_type->name == "Supervisor"){
      $projects = Project::where('supervisor', $user->id)->get();

      return view('content.dashboard.dashboards-supervisor', [
        'projects'=>$projects,
      ]);
    }else{
      $projects = Project::where('supervisor', $user->id)->get();

      return view('content.dashboard.dashboards-supervisor', [
        'projects'=>$projects,
      ]);
    }
    
  }
}
