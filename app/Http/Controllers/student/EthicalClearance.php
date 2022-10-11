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
use App\Models\Clearance;
use App\Models\User;
use Auth;

class EthicalClearance extends Controller
{
    public function index()
    {   
        $user = Auth::user();

        if($user){
            $project = Project::where('student', $user->id)->first();
            $userStatus = Status::where('id', $user->status)->first();
            if($project){ 
                //get ethical clearance
                $clearance = Clearance::where('project', $project->id)->first();
                $projectStatus = Status::where('id', $project->status)->first();
                if($clearance){
                    $projectAttachments = projectAttachment::where('project', $project->id)->where('stage', 2)->get();
                    $status = Status::where('id', $clearance->status)->first();
                    $user_type = UserType::where('id', $user->user_type)->get();
                    $comments = Comment::where('project', $project->id)->where('stage', 2)->get();
                    $commentarray = array();

                    foreach($comments as $comment){
                        $commenter = User::where('id', $comment->user)->first();
                        $push = (object)array("id"=>$comment->id,"first_name"=>$commenter->first_name, "last_name"=>$commenter->last_name,"name"=>$comment->name, "date_made"=>$comment->date_made);
                        array_push($commentarray, $push);
                    }

                    if($clearance){
                        return view('content.student.view-ethical-clearance', [
                            'user'=>$user,
                            'project'=>$project,
                            'status'=>$status,
                            'user_type'=>$user_type,
                            'userStatus'=>$userStatus,
                            'comments'=>$commentarray,
                            'projectStatus'=>$projectStatus,
                            'projectAttachments'=>$projectAttachments,
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
                Project::where('id',$request->project_id)->update(['stage'=>'1']);
                if(Clearance::where('project', $request->project_id)->delete()){
                    ProjectAttachment::where('project', $request->project_id)->where('stage', 2)->delete();
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
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-Application-for-ethical-clearance")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 4)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $request->project_id;
                    $newProjectAttachment1->project_attachment_type = 4;
                    $newProjectAttachment1->name = "Application for ethical clearance";
                    $newProjectAttachment1->downlink = "$user_id-$date-Application-for-ethical-clearance";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 2;

                    $newProjectAttachment1->save();
                }
            }

            if($request->file2){
                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-Three-page-summary")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 5)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $request->project_id;
                    $newProjectAttachment2->project_attachment_type = 5;
                    $newProjectAttachment2->name = "Applicant information sheet";
                    $newProjectAttachment2->downlink = "$user_id-$date-Applicant-information-sheet";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 2;

                    $newProjectAttachment2->save();
                }
            }

            if($request->file3){
                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-Five-page-summary")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 6)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $request->project_id;
                    $newProjectAttachment3->project_attachment_type = 6;
                    $newProjectAttachment3->name = "Ethical clearance form";
                    $newProjectAttachment3->downlink = "$user_id-$date-Ethical-clearance-form";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 2;

                    $newProjectAttachment3->save();
                }
            }

            //update end

            $clearance = Clearance::where('project', $request->project_id)->first();
            if($clearance){ 

                return redirect()->intended(route('student-ethical-clearance'))->withSuccess('Changes made successfully')->withInput();
                
            }else{
                $intakes = Intake::all();
                $programmes = Programme::where('department', $user->department)->get();
                return view('content.student.student-ethical-clearance', [
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

            $existingUser = Clearance::where('project', $project)->first();
            
            $user_id = $user->id;

            if ($existingUser) {
                return redirect()->back()->withError('You have already applied for clearance. You cannot apply twice')->withInput();
            }

            //validate attachments
            if ($request->hasFile('file1')) {

                $file1 = $request->file('file1');
                $fileExtensions = $file1->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Application needs to be in PDF format')->withInput();
                }
                if($request->file('file1')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (One page summary).')->withInput();
                }
            }

            if ($request->hasFile('file2')) {

                $file2 = $request->file('file2');
                $fileExtensions = $file2->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Information sheet needs to be in PDF format')->withInput();
                }
                if($request->file('file2')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Three page summary).')->withInput();
                }
            }

            if ($request->hasFile('file3')) {

                $file3 = $request->file('file3');
                $fileExtensions = $file3->getClientOriginalExtension();
                if (strtolower($fileExtensions) != "pdf") {
                    return redirect()->back()->withError('Clearance form needs to be in PDF format')->withInput();
                }
                if($request->file('file3')->getSize() >= 10000000){
                    return redirect()->back()->withError('Maximum file size exceeded (Five page summary).')->withInput();
                }
            }


            DB::beginTransaction();

            try {

                $newClearance = new Clearance();

                $newClearance->project = $request->project_id;
                $newClearance->status = 1;
                
                $newClearance->save();

                //project id
                $project_id = $request->project_id;
                Project::where('id',$request->project_id)->update(['stage'=>'2']);
                $date = date('U');

                //save project attachments now
                
                $destinationPath = 'public/uploads/';
                if($request->file('file1')->storeAs($destinationPath,  "$user_id-$date-Application-for-ethical-clearance")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 4)->delete();
                    $newProjectAttachment1 = new ProjectAttachment();
                    
                    $newProjectAttachment1->project = $project_id;
                    $newProjectAttachment1->project_attachment_type = 4;
                    $newProjectAttachment1->name = "Application for ethical clearance";
                    $newProjectAttachment1->downlink = "$user_id-$date-Application-for-ethical-clearance";
                    $newProjectAttachment1->format = "PDF";
                    $newProjectAttachment1->stage = 2;

                    $newProjectAttachment1->save();
                }

                if($request->file('file2')->storeAs($destinationPath,  "$user_id-$date-Applicant-information-sheet")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 5)->delete();
                    $newProjectAttachment2 = new ProjectAttachment();

                    $newProjectAttachment2->project = $project_id;
                    $newProjectAttachment2->project_attachment_type = 5;
                    $newProjectAttachment2->name = "Applicant information sheet";
                    $newProjectAttachment2->downlink = "$user_id-$date-Applicant-information-sheet";
                    $newProjectAttachment2->format = "PDF";
                    $newProjectAttachment2->stage = 2;

                    $newProjectAttachment2->save();
                }

                if($request->file('file3')->storeAs($destinationPath,  "$user_id-$date-Ethical-clearance-form")){
                    ProjectAttachment::where('project', $request->project_id)->where('project_attachment_type', 6)->delete();
                    $newProjectAttachment3 = new ProjectAttachment();

                    $newProjectAttachment3->project = $project_id;
                    $newProjectAttachment3->project_attachment_type = 6;
                    $newProjectAttachment3->name = "Ethical clearance form";
                    $newProjectAttachment3->downlink = "$user_id-$date-Ethical-clearance-form";
                    $newProjectAttachment3->format = "PDF";
                    $newProjectAttachment3->stage = 2;

                    $newProjectAttachment3->save();
                    
                }

                DB::commit();
                return redirect()->intended(route('student-ethical-clearance'))->withSuccess('Application request successful')->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
            }
        }else{
            return route('login');
        }
        
    }
}
