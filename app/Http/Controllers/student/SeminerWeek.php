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
use App\Models\User;
use Auth;

class SeminerWeek extends Controller
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
                            $projectAttachments = projectAttachment::where('project', $project->id)->where('stage', 4)->get();
                            $status = Status::where('id', $seminerWeek->status)->first();
                            $user_type = UserType::where('id', $user->user_type)->get();
                            $comments = Comment::where('project', $project->id)->where('stage', 4)->get();
                            $commentarray = array();
                            $supervisor = User::where('id', $project->supervisor)->first();
                            
                            foreach($comments as $comment){
                                $commenter = User::where('id', $comment->user)->first();
                                $push = (object)array("id"=>$comment->id,"first_name"=>$commenter->first_name, "last_name"=>$commenter->last_name,"name"=>$comment->name, "date_made"=>$comment->date_made);
                                array_push($commentarray, $push);
                            }

                            return view('content.student.view-seminer-week', [
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
                Project::where('id',$request->project_id)->update(['stage'=>'3']);
                if(Seminer::where('project', $request->project_id)->delete()){
                    ProjectAttachment::where('project', $request->project_id)->where('stage', 4)->delete();
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
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-abstract")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 11)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $request->project_id;
                    $newProjectAttachment1->project_attachment_type = 11;
                    $newProjectAttachment1->name = "Abstract";
                    $newProjectAttachment1->downlink = "$user_id-$date-abstract";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 4;

                    $newProjectAttachment1->save();
                }
            }

            if($request->file2){
                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-email-proof")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 12)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $request->project_id;
                    $newProjectAttachment2->project_attachment_type = 12;
                    $newProjectAttachment2->name = "Email proof";
                    $newProjectAttachment2->downlink = "$user_id-$date-email-proof";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 4;

                    $newProjectAttachment2->save();
                }
            }

            if($request->file3){
                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-poster")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 13)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $request->project_id;
                    $newProjectAttachment3->project_attachment_type = 13;
                    $newProjectAttachment3->name = "Poster";
                    $newProjectAttachment3->downlink = "$user_id-$date-poster";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 4;

                    $newProjectAttachment3->save();
                }
            }


            if($request->file4){
                if($request->file('file4')->storeAs($destinationPath,  "$user_id-$date-slides")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 14)->delete();
                    $newProjectAttachment4 = new ProjectAttachment();

                    $newProjectAttachment4->project = $request->project_id;
                    $newProjectAttachment4->project_attachment_type = 14;
                    $newProjectAttachment4->name = "Powerpoint slides";
                    $newProjectAttachment4->downlink = "$user_id-$date-slides";
                    $newProjectAttachment4->format = "PPTX";
                    $newProjectAttachment4->stage = 4;

                    $newProjectAttachment4->save();
                }
            }

            //update end

            $seminer = Seminer::where('project', $request->project_id)->first();
            if($seminer){ 

                return redirect()->intended(route('student-seminer-week'))->withSuccess('Changes made successfully')->withInput();
                
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.student-seminer-week', [
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

            $existingUser = Seminer::where('project', $project)->first();
            
            $user_id = $user->id;

            if ($existingUser) {
                return redirect()->back()->withError('You have already applied for Seminer Week. You cannot apply twice')->withInput();
            }

            //validate attachments
            if ($request->hasFile('file1')) {

                $file1 = $request->file('file1');
                $fileExtensions = $file1->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Abstract needs to be in PDF format')->withInput();
                }
                if($request->file('file1')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Abstract).')->withInput();
                }
            }

            if ($request->hasFile('file2')) {

                $file2 = $request->file('file2');
                $fileExtensions = $file2->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Email proof needs to be in PDF format')->withInput();
                }
                if($request->file('file2')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Email proof).')->withInput();
                }
            }

            if ($request->hasFile('file3')) {

                $file3 = $request->file('file3');
                $fileExtensions = $file3->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Poster needs to be in PDF format')->withInput();
                }
                if($request->file('file3')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Poster).')->withInput();
                }
            }


            if ($request->hasFile('file4')) {

                $file3 = $request->file('file4');
                $fileExtensions = $file3->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pptx") {
                    return redirect()->back()->withError('slides form needs to be in PPTX format')->withInput();
                }
                if($request->file('file3')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Poster).')->withInput();
                }
            }


            DB::beginTransaction();

            try {

                $newSeminer = new Seminer();

                $newSeminer->project = $request->project_id;
                $newSeminer->status = 1;
                
                $newSeminer->save();

                //project id
                $project_id = $request->project_id;
                Project::where('id',$request->project_id)->update(['stage'=>'4']);
                $date = date('U');

                //save project attachments now
                
                $destinationPath = 'public/uploads/';
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-abstract")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 11)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $project_id;
                    $newProjectAttachment1->project_attachment_type = 11;
                    $newProjectAttachment1->name = "Abstract";
                    $newProjectAttachment1->downlink = "$user_id-$date-abstract";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 4;

                    $newProjectAttachment1->save();
                }

                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-email-proof")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 12)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $project_id;
                    $newProjectAttachment2->project_attachment_type = 12;
                    $newProjectAttachment2->name = "Email proof";
                    $newProjectAttachment2->downlink = "$user_id-$date-email-proof";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 4;

                    $newProjectAttachment2->save();
                }

                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-poster")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 13)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $project_id;
                    $newProjectAttachment3->project_attachment_type = 13;
                    $newProjectAttachment3->name = "Poster";
                    $newProjectAttachment3->downlink = "$user_id-$date-poster";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 4;

                    $newProjectAttachment3->save();
                    
                }

                if($request->file3){
                    if($request->file('file4')->storeAs($destinationPath,  "$user_id-$date-slides")){
                        ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 14)->delete();
                        $newProjectAttachment4 = new ProjectAttachment();
    
                        $newProjectAttachment4->project = $request->project_id;
                        $newProjectAttachment4->project_attachment_type = 14;
                        $newProjectAttachment4->name = "Powerpoint slides";
                        $newProjectAttachment4->downlink = "$user_id-$date-slides";
                        $newProjectAttachment4->format = "PDF";
                        $newProjectAttachment4->stage = 4;
    
                        $newProjectAttachment4->save();
                    }
                }

                DB::commit();
                return redirect()->intended(route('student-seminer-week'))->withSuccess('Application request successful')->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
            }
        }else{
            return route('login');
        }
        
    }
}
