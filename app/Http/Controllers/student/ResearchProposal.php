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
use App\Models\User;
use Auth;

class ResearchProposal extends Controller
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
                        $projectAttachments = projectAttachment::where('project', $project->id)->where('stage', 3)->get();
                        $status = Status::where('id', $Research->status)->first();
                        $user_type = UserType::where('id', $user->user_type)->get();
                        $comments = Comment::where('project', $project->id)->where('stage', 3)->get();
                        $commentarray = array();
                        $supervisor = User::where('id', $project->supervisor)->first();
                        
                        foreach($comments as $comment){
                            $commenter = User::where('id', $comment->user)->first();
                            $push = (object)array("id"=>$comment->id,"first_name"=>$commenter->first_name, "last_name"=>$commenter->last_name,"name"=>$comment->name, "date_made"=>$comment->date_made);
                            array_push($commentarray, $push);
                        }

                        return view('content.student.view-research-proposal', [
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
                Project::where('id',$request->project_id)->update(['stage'=>'2']);
                if(Research::where('project', $request->project_id)->delete()){
                    ProjectAttachment::where('project', $request->project_id)->where('stage', 3)->delete();
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
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-one-page")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 7)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $request->project_id;
                    $newProjectAttachment1->project_attachment_type = 7;
                    $newProjectAttachment1->name = "One page summary";
                    $newProjectAttachment1->downlink = "$user_id-$date-one-page";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 3;

                    $newProjectAttachment1->save();
                }
            }

            if($request->file2){
                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-three-page")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 8)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $request->project_id;
                    $newProjectAttachment2->project_attachment_type = 8;
                    $newProjectAttachment2->name = "Three page summary";
                    $newProjectAttachment2->downlink = "$user_id-$date-three-page";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 3;

                    $newProjectAttachment2->save();
                }
            }

            if($request->file3){
                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-five-page")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 9)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $request->project_id;
                    $newProjectAttachment3->project_attachment_type = 9;
                    $newProjectAttachment3->name = "Five page summary";
                    $newProjectAttachment3->downlink = "$user_id-$date-five-page";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 3;

                    $newProjectAttachment3->save();
                }
            }


            if($request->file3){
                if($request->file('file4')->storeAs($destinationPath,  "$user_id-$date-presentation")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 10)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $request->project_id;
                    $newProjectAttachment3->project_attachment_type = 10;
                    $newProjectAttachment3->name = "Powerpoint presentation";
                    $newProjectAttachment3->downlink = "$user_id-$date-presentation";
                    $newProjectAttachment3->format = "PPTX";
                    $newProjectAttachment3->stage = 3;

                    $newProjectAttachment3->save();
                }
            }

            //update end

            $research = Research::where('project', $request->project_id)->first();
            if($research){ 

                return redirect()->intended(route('student-research-proposal'))->withSuccess('Changes made successfully')->withInput();
                
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.student-research-proposal', [
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
                return redirect()->back()->withError('Research could not be attached!')->withInput();
            }

            $existingUser = Research::where('project', $project)->first();
            
            $user_id = $user->id;

            if ($existingUser) {
                return redirect()->back()->withError('You have already applied for Research. You cannot apply twice')->withInput();
            }

            //validate attachments
            if ($request->hasFile('file1')) {

                $file1 = $request->file('file1');
                $fileExtensions = $file1->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('One page summary needs to be in PDF format')->withInput();
                }
                if($request->file('file1')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (One page summary).')->withInput();
                }
            }

            if ($request->hasFile('file2')) {

                $file2 = $request->file('file2');
                $fileExtensions = $file2->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Three page summary needs to be in PDF format')->withInput();
                }
                if($request->file('file2')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Three page summary).')->withInput();
                }
            }

            if ($request->hasFile('file3')) {

                $file3 = $request->file('file3');
                $fileExtensions = $file3->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Five page summary needs to be in PDF format')->withInput();
                }
                if($request->file('file3')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Five page summary).')->withInput();
                }
            }


            if ($request->hasFile('file4')) {

                $file3 = $request->file('file4');
                $fileExtensions = $file3->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pptx") {
                    return redirect()->back()->withError('Presentation form needs to be in PPTX format')->withInput();
                }
                if($request->file('file3')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Five page summary).')->withInput();
                }
            }


            DB::beginTransaction();

            try {

                $newResearch = new Research();

                $newResearch->project = $request->project_id;
                $newResearch->status = 1;
                
                $newResearch->save();

                //project id
                $project_id = $request->project_id;
                Project::where('id',$request->project_id)->update(['stage'=>'3']);
                $date = date('U');

                //save project attachments now
                
                $destinationPath = 'public/uploads/';
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-one-page")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 7)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $project_id;
                    $newProjectAttachment1->project_attachment_type = 7;
                    $newProjectAttachment1->name = "One page summary";
                    $newProjectAttachment1->downlink = "$user_id-$date-one-page";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 3;

                    $newProjectAttachment1->save();
                }

                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-three-page")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 8)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $project_id;
                    $newProjectAttachment2->project_attachment_type = 8;
                    $newProjectAttachment2->name = "Three page summary";
                    $newProjectAttachment2->downlink = "$user_id-$date-three-page";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 3;

                    $newProjectAttachment2->save();
                }

                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-five-page")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 9)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $project_id;
                    $newProjectAttachment3->project_attachment_type = 9;
                    $newProjectAttachment3->name = "Five page summary";
                    $newProjectAttachment3->downlink = "$user_id-$date-five-page";
                    $newProjectAttachment3->format = "PPTX";
                    $newProjectAttachment3->stage = 3;

                    $newProjectAttachment3->save();
                    
                }

                if($request->file3){
                    if($request->file('file4')->storeAs($destinationPath,  "$user_id-$date-presentation")){
                        ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 10)->delete();
                        $newProjectAttachment3 = new ProjectAttachment();
    
                        $newProjectAttachment3->project = $request->project_id;
                        $newProjectAttachment3->project_attachment_type = 10;
                        $newProjectAttachment3->name = "Powerpoint presentation";
                        $newProjectAttachment3->downlink = "$user_id-$date-presentation";
                        $newProjectAttachment3->format = "PDF";
                        $newProjectAttachment3->stage = 3;
    
                        $newProjectAttachment3->save();
                    }
                }

                DB::commit();
                return redirect()->intended(route('student-research-proposal'))->withSuccess('Application request successful')->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
            }
        }else{
            return route('login');
        }
        
    }
}
