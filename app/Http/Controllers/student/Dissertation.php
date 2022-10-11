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
use App\Models\Research;
use App\Models\Clearance;
use App\Models\Seminer;
use App\Models\Dissertations;
use App\Models\User;
use Auth;

class Dissertation extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        if($user){
            $project = Project::where('student', $user->id)->first();
            $userStatus = Status::where('id', $user->status)->first();
            if($project){ 
                //get ethical Research
                $clearance = Clearance::where('project', $project->id)->first();
                $projectStatus = Status::where('id', $project->status)->first();
                if($clearance){ 
                    $Research = Research::where('project', $project->id)->first();
                    $projectStatus = Status::where('id', $clearance->status)->first();
                    if($Research){ 
                        $seminerWeek = Seminer::where('project', $project->id)->first();
                        $projectStatus = Status::where('id', $Research->status)->first();
                        if($seminerWeek){
                            $dissertations = Dissertations::where('project', $project->id)->first();
                            $projectStatus = Status::where('id', $seminerWeek->status)->first();
                            if($dissertations){
                                $projectAttachments = projectAttachment::where('project', $project->id)->where('stage', 5)->get();
                                $status = Status::where('id', $dissertations->status)->first();
                                $user_type = UserType::where('id', $user->user_type)->get();
                                $comments = Comment::where('project', $project->id)->where('stage', 5)->get();
                                $commentarray = array();
                                $supervisor = User::where('id', $project->supervisor)->first();
                                
                                foreach($comments as $comment){
                                    $commenter = User::where('id', $comment->user)->first();
                                    $push = (object)array("id"=>$comment->id,"first_name"=>$commenter->first_name, "last_name"=>$commenter->last_name,"name"=>$comment->name, "date_made"=>$comment->date_made);
                                    array_push($commentarray, $push);
                                }

                                return view('content.student.view-dissertation', [
                                    'user'=>$user,
                                    'project'=>$project,
                                    'status'=>$status,
                                    'user_type'=>$user_type,
                                    'userStatus'=>$userStatus,
                                    'comments'=>$commentarray,
                                    'projectStatus'=>$projectStatus,
                                    'projectAttachments'=>$projectAttachments,
                                    'supervisor'=>$supervisor,
                                ]);
                            }else{
                                return view('content.student.apply-dissertation', [
                                    'project'=>$project,
                                    'projectStatus'=>$projectStatus,
                                ]);
                            }
                        }else{
                            return view('content.student.apply-seminer-week', [
                                'project'=>$project,
                                'projectStatus'=>$projectStatus,
                            ]);
                        }
                    }else{
                        return view('content.student.apply-research-proposal', [
                            'project'=>$project,
                            'projectStatus'=>$projectStatus,
                        ]);
                    }
                }else{
                    return view('content.student.apply-ethical-clearance', [
                        'project'=>$project,
                        'projectStatus'=>$projectStatus,
                    ]);
                }
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.student-register', [
                    'intakes'=>$intakes,
                    'programmes'=>$programmes,
                    'userStatus'=>$userStatus,
                ]);
            }
        }
    }


    public function delete(Request $request)
    {   
        $user = Auth::user();
        
        if($user){ 
            //update start
            if($request->project_id){
                Project::where('id',$request->project_id)->update(['stage'=>'4']);
                if(Dissertations::where('project', $request->project_id)->delete()){
                    ProjectAttachment::where('project', $request->project_id)->where('stage', 5)->delete();
                    return redirect()->intended(route('dashboard'))->withSuccess('Your submission has been retracted successfully.')->withInput();
                }
            }
        }
    }

    
    public function update(Request $request)
    {   
        $user = Auth::user();
        
        if($user){

            $date = date('U');
            $user_id = $user->id;
            $destinationPath = 'public/uploads/';


            if($request->file1){
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-dissertation")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 15)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $request->project_id;
                    $newProjectAttachment1->project_attachment_type = 15;
                    $newProjectAttachment1->name = "Dissetation";
                    $newProjectAttachment1->downlink = "$user_id-$date-dissertation";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 5;

                    $newProjectAttachment1->save();
                }
            }

            

            //update end

            $seminer = Dissertations::where('project', $request->project_id)->first();
            if($seminer){ 
                return redirect()->intended(route('student-dissertation'))->withSuccess('Changes made successfully')->withInput();
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.apply-dissertation', [
                    'intakes'=>$intakes,
                    'programmes'=>$programmes,
                ]);
            }
        }
    }

    public function save(Request $request)
    {   
        $user = Auth::user();

        if($user){
            $project = trim($request->project_id);
            
            if (!$project ) {
                return redirect()->back()->withError('Dissertation could not be attached!')->withInput();
            }

            $existingUser = Dissertations::where('project', $project)->first();
            
            $user_id = $user->id;
            
            if ($existingUser) {
                return redirect()->back()->withError('You have already Submitted your dissertation. You cannot apply twice')->withInput();
            }

            //validate attachments
            if ($request->hasFile('file1')) {

                $file1 = $request->file('file1');
                $fileExtensions = $file1->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Dissertation needs to be in PDF format')->withInput();
                }
                if($request->file('file1')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Abstract).')->withInput();
                }
            }


            DB::beginTransaction();

            try {

                $newDissertation = new Dissertations();

                $newDissertation->project = $request->project_id;
                $newDissertation->status = 1;
                
                $newDissertation->save();

                //project id
                $project_id = $request->project_id;
                Project::where('id',$request->project_id)->update(['stage'=>'5']);
                $date = date('U');

                //save project attachments now
                
                $destinationPath = 'public/uploads/';
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-dissertation")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 15)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $project_id;
                    $newProjectAttachment1->project_attachment_type = 15;
                    $newProjectAttachment1->name = "Dissertation";
                    $newProjectAttachment1->downlink = "$user_id-$date-dissertation";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 5;

                    $newProjectAttachment1->save();
                }

                
                DB::commit();
                return redirect()->intended(route('student-dissertation'))->withSuccess('Application request successful')->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
            }
        }else{
            return route('login');
        }
        
    }
}
