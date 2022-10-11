<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Programme;
use App\Models\Intake;
use App\Models\Status;
use App\Models\UserType;
use App\Models\School;
use App\Models\Department;
use Auth;

class Projects extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user){
            //return var
            $return = array();

            $projects = Project::all();

            foreach($projects as $project){
                $project_details = (object)array(
                    "name"=>$project->name,
                    "id"=>$project->id,
                    "start_date"=>$project->start_date,
                    "end_date"=>$project->end_date,
                    "stage"=>$project->stage,
                    "status"=>Status::where('id', $project->status)->first()->name,
                    "color"=>Status::where('id', $project->status)->first()->color,
                );

                $project_owner = User::where('id', $project->student)->first();
                if( $project_owner ){
                    $owner_details = array(
                        "id"=>$project_owner->id,
                        "first_name"=>$project_owner->first_name,
                        "last_name"=>$project_owner->last_name,
                        "number"=>$project_owner->number,
                        "phone"=>$project_owner->phone,
                        "email"=>$project_owner->email,
                        "status"=>Status::where('id', $project_owner->status)->first()->name,
                        "user_type"=>UserType::where('id', $project_owner->user_type)->first()->name,
                        "school"=>School::where('id', $project_owner->school)->first()->name,
                        "department"=>Department::where('id', $project_owner->department)->first()->name,
                        "avater"=>$project_owner->avater,
                    );
                }else{$owner_details = array();}

                $project_supervisor = User::where('id', $project->supervisor)->first();
                if( $project_supervisor ){
                    $supervisor_details = array(
                        "id"=>$project_supervisor->id,
                        "first_name"=>$project_supervisor->first_name,
                        "last_name"=>$project_supervisor->last_name,
                        "number"=>$project_supervisor->number,
                        "phone"=>$project_supervisor->phone,
                        "email"=>$project_supervisor->email,
                        "status"=>Status::where('id', $project_supervisor->status)->first()->name,
                        "user_type"=>UserType::where('id', $project_supervisor->user_type)->first()->name,
                        "school"=>School::where('id', $project_supervisor->school)->first()->name,
                        "department"=>Department::where('id', $project_supervisor->department)->first()->name,
                        "avater"=>$project_supervisor->avater,
                    );
                }else{$supervisor_details = array();}


                $project_assessor = User::where('id', $project->assessor)->first();
                if( $project_assessor ){
                    $assessor_details = array(
                        "id"=>$project_assessor->id,
                        "first_name"=>$project_assessor->first_name,
                        "last_name"=>$project_assessor->last_name,
                        "number"=>$project_assessor->number,
                        "phone"=>$project_assessor->phone,
                        "email"=>$project_assessor->email,
                        "status"=>Status::where('id', $project_assessor->status)->first()->name,
                        "user_type"=>UserType::where('id', $project_assessor->user_type)->first()->name,
                        "school"=>School::where('id', $project_assessor->school)->first()->name,
                        "department"=>Department::where('id', $project_assessor->department)->first()->name,
                        "avater"=>$project_assessor->avater,
                    );
                }else{$assessor_details = array();}


                $project_school = School::where('id', $project->school)->first();
                if( $project_school ){
                    $school_details = array(
                        "id"=>$project_school->id,
                        "name"=>$project_school->name,
                    );
                }else{$school_details = array();}


                $project_department = Department::where('id', $project->department)->first();
                if( $project_department ){
                    $department_details = array(
                        "id"=>$project_department->id,
                        "name"=>$project_department->name,
                    );
                }else{$department_details = array();}


                $project_programme = Programme::where('id', $project->programme)->first();
                if( $project_programme ){
                    $programme_details = array(
                        "id"=>$project_programme->id,
                        "name"=>$project_programme->name,
                    );
                }else{$programme_details = array();}

                $project_status = Status::where('id', $project->status)->first();
                if( $project_status ){
                    $project_status_details = array(
                        "id"=>$project_status->id,
                        "name"=>$project_status->name,
                    );
                }else{$project_status_details = array();}

                $project_intake = Intake::where('id', $project->intake)->first();
                if( $project_intake ){
                    $project_intake_details = array(
                        "id"=>$project_intake->id,
                        "name"=>$project_intake->name,
                    );
                }else{$project_intake_details = array();}
                
                

                $obj = (object)array(
                    "project_details"=>(object)$project_details,
                    "owner_details"=>(object)$owner_details,
                    "supervisor_details"=>(object)$supervisor_details,
                    "assessor_details"=>(object)$assessor_details,
                    "school_details"=>(object)$school_details,
                    "programme_details"=>(object)$programme_details,
                    "project_status_details"=>(object)$project_status_details,
                    "project_intake_details"=>(object)$project_intake_details,
                );

                array_push($return,$obj);
            }

            return view('content.user.view-projects', [
                'projects'=>$return,
                'user'=>$user,
            ]);

        }
    }


    public function project(Request $request)
    {
        $user = Auth::user();
        if($user){
            //return var
            $return = array();

            $project = Project::where('id', $request->id)->first();
            
            if($project){
                $project_details = (object)array(
                    "name"=>$project->name,
                    "id"=>$project->id,
                    "start_date"=>$project->start_date,
                    "end_date"=>$project->end_date,
                    "stage"=>$project->stage,
                    "status"=>Status::where('id', $project->status)->first()->name,
                    "color"=>Status::where('id', $project->status)->first()->color,
                );

                $project_owner = User::where('id', $project->student)->first();
                if( $project_owner ){
                    $owner_details = array(
                        "id"=>$project_owner->id,
                        "first_name"=>$project_owner->first_name,
                        "last_name"=>$project_owner->last_name,
                        "number"=>$project_owner->number,
                        "phone"=>$project_owner->phone,
                        "email"=>$project_owner->email,
                        "status"=>Status::where('id', $project_owner->status)->first()->name,
                        "user_type"=>UserType::where('id', $project_owner->user_type)->first()->name,
                        "school"=>School::where('id', $project_owner->school)->first()->name,
                        "department"=>Department::where('id', $project_owner->department)->first()->name,
                        "avater"=>$project_owner->avater,
                    );
                }else{$owner_details = array();}

                $project_supervisor = User::where('id', $project->supervisor)->first();
                if( $project_supervisor ){
                    $supervisor_details = array(
                        "id"=>$project_supervisor->id,
                        "first_name"=>$project_supervisor->first_name,
                        "last_name"=>$project_supervisor->last_name,
                        "number"=>$project_supervisor->number,
                        "phone"=>$project_supervisor->phone,
                        "email"=>$project_supervisor->email,
                        "status"=>Status::where('id', $project_supervisor->status)->first()->name,
                        "user_type"=>UserType::where('id', $project_supervisor->user_type)->first()->name,
                        "school"=>School::where('id', $project_supervisor->school)->first()->name,
                        "department"=>Department::where('id', $project_supervisor->department)->first()->name,
                        "avater"=>$project_supervisor->avater,
                    );
                }else{$supervisor_details = array();}


                $project_assessor = User::where('id', $project->assessor)->first();
                if( $project_assessor ){
                    $assessor_details = array(
                        "id"=>$project_assessor->id,
                        "first_name"=>$project_assessor->first_name,
                        "last_name"=>$project_assessor->last_name,
                        "number"=>$project_assessor->number,
                        "phone"=>$project_assessor->phone,
                        "email"=>$project_assessor->email,
                        "status"=>Status::where('id', $project_assessor->status)->first()->name,
                        "user_type"=>UserType::where('id', $project_assessor->user_type)->first()->name,
                        "school"=>School::where('id', $project_assessor->school)->first()->name,
                        "department"=>Department::where('id', $project_assessor->department)->first()->name,
                        "avater"=>$project_assessor->avater,
                    );
                }else{$assessor_details = array();}


                $project_school = School::where('id', $project->school)->first();
                if( $project_school ){
                    $school_details = array(
                        "id"=>$project_school->id,
                        "name"=>$project_school->name,
                    );
                }else{$school_details = array();}


                $project_department = Department::where('id', $project->department)->first();
                if( $project_department ){
                    $department_details = array(
                        "id"=>$project_department->id,
                        "name"=>$project_department->name,
                    );
                }else{$department_details = array();}


                $project_programme = Programme::where('id', $project->programme)->first();
                if( $project_programme ){
                    $programme_details = array(
                        "id"=>$project_programme->id,
                        "name"=>$project_programme->name,
                    );
                }else{$programme_details = array();}

                $project_status = Status::where('id', $project->status)->first();
                if( $project_status ){
                    $project_status_details = array(
                        "id"=>$project_status->id,
                        "name"=>$project_status->name,
                    );
                }else{$project_status_details = array();}

                $project_intake = Intake::where('id', $project->intake)->first();
                if( $project_intake ){
                    $project_intake_details = array(
                        "id"=>$project_intake->id,
                        "name"=>$project_intake->name,
                    );
                }else{$project_intake_details = array();}
                
                

                $obj = (object)array(
                    "project_details"=>(object)$project_details,
                    "owner_details"=>(object)$owner_details,
                    "supervisor_details"=>(object)$supervisor_details,
                    "assessor_details"=>(object)$assessor_details,
                    "school_details"=>(object)$school_details,
                    "programme_details"=>(object)$programme_details,
                    "project_status_details"=>(object)$project_status_details,
                    "project_intake_details"=>(object)$project_intake_details,
                );

                array_push($return,$obj);
            }

            return view('content.user.view-project', [
                'projects'=>$return,
                'user'=>$user,
            ]);

        }
    }
}
