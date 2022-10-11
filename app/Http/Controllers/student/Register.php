<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\ProjectAttachment;
use App\Models\Programme;
use App\Models\School;
use App\Models\Department;
use App\Models\Intake;
use App\Models\Status;
use App\Models\UserType;
use App\Models\Comment;
use App\Models\ModeOfTraining;
use App\Models\ProgrammeLevel;
use App\Models\User;
use Auth;

class Register extends Controller
{
    public function register()
    {   
        $user = Auth::user();

        if($user){
            $project = Project::where('student', $user->id)->first();
            $userStatus = Status::where('id', $user->status)->first();
            $modes = ModeOfTraining::all();
            $levels = ProgrammeLevel::all();
            if($project){ 
                $projectAttachments = projectAttachment::where('project', $project->id)->where('stage', 1)->get();
                $school = School::where('id', $project->school)->first();
                $department = Department::where('id', $project->department)->first();
                $programme = Programme::where('id', $project->programme)->first();
                $mode = ModeOfTraining::where('id', $project->mode)->first();
                $level = ProgrammeLevel::where('id', $project->level)->first();
                $intake = Intake::where('id', $project->intake)->first();
                $status = Status::where('id', $project->status)->first();
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                $user_type = UserType::where('id', $user->user_type)->get();
                $comments = Comment::where('project', $project->id)->where('stage', 1)->get();
                $commentarray = array();

                foreach($comments as $comment){
                    $commenter = User::where('id', $comment->user)->first();
                    $push = (object)array("id"=>$comment->id,"first_name"=>$commenter->first_name, "last_name"=>$commenter->last_name,"name"=>$comment->name, "date_made"=>$comment->date_made);
                    array_push($commentarray, $push);
                }

                return view('content.student.view-registration', [
                    'user'=>$user,
                    'project'=>$project,
                    'projectAttachments'=>$projectAttachments,
                    'programme'=>$programme,
                    'school'=>$school,
                    'department'=>$department,
                    'intake'=>$intake,
                    'status'=>$status, 
                    'intakes'=>$intakes,
                    'programmes'=>$programmes,
                    'levels'=>$levels,
                    'level'=>$level,
                    'mode'=>$mode,
                    'modes'=>$modes,
                    'user_type'=>$user_type,
                    'userStatus'=>$userStatus,
                    'comments'=>$commentarray,
                ]);
                
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.student-register', [
                    'intakes'=>$intakes,
                    'programmes'=>$programmes,
                    'userStatus'=>$userStatus,
                    'levels'=>$levels,
                    'modes'=>$modes,
                ]);
            }
        }
    }


    public function registerDelete(Request $request)
    {   
        $user = Auth::user();
        
        if($user){
            //update start
            if($request->project_id){
                if(Project::where('id', $request->project_id)->delete()){
                    ProjectAttachment::where('project', $request->project_id)->where('stage', 1)->delete();
                    return redirect()->intended(route('dashboard'))->withSuccess('Your registration request has been retracted successfully.')->withInput();
                }
            }
        }
    }

    
    public function registerUpdate(Request $request)
    {   
        $user = Auth::user();
        
        if($user){

            //update start
            if($request->project){
                Project::where('id',$request->project_id)->update(['name'=>$request->project]);
            }

            if($request->programme){
                Project::where('id',$request->project_id)->update(['programme'=>$request->programme]);
            }

            if($request->level){
                Project::where('id',$request->project_id)->update(['level'=>$request->level]);
            }


            if($request->mode){
                Project::where('id',$request->project_id)->update(['mode'=>$request->mode]);
            }

            if($request->start_date){
                Project::where('id',$request->project_id)->update(['start_date'=>$request->start_date]);
            }

            if($request->end_date){
                Project::where('id',$request->project_id)->update(['end_date'=>$request->end_date]);
            }

            if($request->intake){
                Project::where('id',$request->project_id)->update(['intake'=>$request->intake]);
            }
            

            $date = date('U');
            $user_id = $user->id;
            $destinationPath = 'public/uploads/';


            if($request->file1){
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-project-proposal")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 1)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $request->project_id;
                    $newProjectAttachment1->project_attachment_type = 1;
                    $newProjectAttachment1->name = "Project proposal";
                    $newProjectAttachment1->downlink = "$user_id-$date-project-proposal";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 1;

                    $newProjectAttachment1->save();
                }
            }

            if($request->file2){
                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-gantt-chart")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 2)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $request->project_id;
                    $newProjectAttachment2->project_attachment_type = 2;
                    $newProjectAttachment2->name = "Gantt chart and timeline";
                    $newProjectAttachment2->downlink = "$user_id-$date-gantt-chart";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 1;

                    $newProjectAttachment2->save();
                }
            }

            if($request->file3){
                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-data-collection-document")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 3)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();
    
                    $newProjectAttachment3->project = $request->project_id;
                    $newProjectAttachment3->project_attachment_type = 3;
                    $newProjectAttachment3->name = "Data collection toold";
                    $newProjectAttachment3->downlink = "$user_id-$date-data-collection-document";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 1;
    
                    $newProjectAttachment3->save();
                }
            }

            //update end

            $project = Project::where('student', $user->id)->first();
            if($project){ 

                return redirect()->intended(route('registration'))->withSuccess('Changes made successfully')->withInput();
                
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.student-register', [
                    'intakes'=>$intakes,
                    'programmes'=>$programmes,
                ]);
            }
        }
    }

    public function registerSave(Request $request)
    {   
        $user = Auth::user();

        if($user){
            $project = trim($request->project);
            $start = $request->start_date;
            $end = $request->end_date;
            $programme = $request->programme;
            $intake = $request->intake;
            $level = $request->level;
            $mode = $request->mode;

            if (!$project || !$start || !$end ) {
                return redirect()->back()->withError('Fill in all the required fields!')->withInput();
            }

            $existingUser = Project::where('student', $user->id)->first();
            
            $user_id = $user->id;

            if ($existingUser) {
                return redirect()->back()->withError('You have already registered. You cannot register twice')->withInput();
            }

            $existingUser = Project::where('name', $project)->first();
            
            if ($existingUser) {
                return redirect()->back()->withError('Project name duplicate. Enter a different project name')->withInput();
            }

            //validate attachments
            if ($request->hasFile('file1')) {

                $file1 = $request->file('file1');
                $fileExtensions = $file1->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Project proposal needs to be in PDF format')->withInput();
                }
                if($request->file('file1')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (One page summary).')->withInput();
                }
            }

            if ($request->hasFile('file2')) {

                $file2 = $request->file('file2');
                $fileExtensions = $file2->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Gantt chart and timelines needs to be in PDF format')->withInput();
                }
                if($request->file('file2')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Three page summary).')->withInput();
                }
            }

            if ($request->hasFile('file3')) {

                $file3 = $request->file('file3');
                $fileExtensions = $file3->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Data collection tools needs to be in PDF format')->withInput();
                }
                if($request->file('file3')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Five page summary).')->withInput();
                }
            }


            DB::beginTransaction();

            try {

                $newProject = new Project();
                

                $newProject->student = $user->id;
                $newProject->name = $project;
                $newProject->start_date = $start;
                $newProject->end_date = $end;
                $newProject->school = $user->school;
                $newProject->department = $user->department;
                $newProject->programme = $programme;
                $newProject->intake = $intake;
                $newProject->level = $level;
                $newProject->mode = $mode;
                $newProject->stage = 1;
                $newProject->status = 1;
                
                $newProject->save();

                //project id
                $project_id = Project::where('name', $project)->first()->id;
                $date = date('U');

                //save project attachments now
                
                $destinationPath = 'public/uploads/';
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-project-proposal")){
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $project_id;
                    $newProjectAttachment1->project_attachment_type = 1;
                    $newProjectAttachment1->name = "Project proposal";
                    $newProjectAttachment1->downlink = "$user_id-$date-project-proposal";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 1;

                    $newProjectAttachment1->save();
                }

                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-gantt-chart")){
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $project_id;
                    $newProjectAttachment2->project_attachment_type = 2;
                    $newProjectAttachment2->name = "Gantt chart and timeline";
                    $newProjectAttachment2->downlink = "$user_id-$date-gantt-chart";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 1;

                    $newProjectAttachment2->save();
                }

                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-data-collection-document")){
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $project_id;
                    $newProjectAttachment3->project_attachment_type = 3;
                    $newProjectAttachment3->name = "Data collection tools";
                    $newProjectAttachment3->downlink = "$user_id-$date-data-collection-document";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 1;

                    $newProjectAttachment3->save();
                    
                }

                DB::commit();
                return redirect()->intended(route('registration'))->withSuccess('Registration request successful')->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
            }
        }else{
            return route('login');
        }
        
    }
}
