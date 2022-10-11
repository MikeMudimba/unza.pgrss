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
use App\Models\Journals;
use App\Models\Completion;
use App\Models\User;
use Auth;

class CompletionLetter extends Controller
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
                            $dissertation = Dissertations::where('project', $project->id)->first();
                            $projectStatus = Status::where('id', $seminerWeek->status)->first();
                            if($dissertation){
                                $journals = Journals::where('project', $project->id)->first();
                                $projectStatus = Status::where('id', $dissertation->status)->first();
                                if($journals){
                                    $completion = Completion::where('project', $project->id)->first();
                                    $projectStatus = Status::where('id', $journals->status)->first();
                                    if($completion){
                                        $projectAttachments = projectAttachment::where('project', $project->id)->where('stage', 7)->get();
                                        $status = Status::where('id', $completion->status)->first();
                                        $user_type = UserType::where('id', $user->user_type)->get();
                                        $comments = Comment::where('project', $project->id)->where('stage', 7)->get();
                                        $commentarray = array();
                                        $supervisor = User::where('id', $project->supervisor)->first();
                                        $school = School::where('id', $project->school)->first();
                                        $department = Department::where('id', $project->department)->first();
                                        $programme = Programme::where('id', $project->programme)->first();
                                        $intake = Intake::where('id', $project->intake)->first();

                                        foreach($comments as $comment){
                                            $commenter = User::where('id', $comment->user)->first();
                                            $push = (object)array("id"=>$comment->id,"first_name"=>$commenter->first_name, "last_name"=>$commenter->last_name,"name"=>$comment->name, "date_made"=>$comment->date_made);
                                            array_push($commentarray, $push);
                                        }

                                        return view('content.student.view-completion-letter', [
                                            'user'=>$user,
                                            'project'=>$project,
                                            'status'=>$status,
                                            'user_type'=>$user_type,
                                            'userStatus'=>$userStatus,
                                            'comments'=>$commentarray,
                                            'projectStatus'=>$projectStatus,
                                            'projectAttachments'=>$projectAttachments,
                                            'supervisor'=>$supervisor,
                                            'intake'=>$intake,
                                            'programme'=>$programme,
                                            'school'=>$school,
                                            'department'=>$department,
                                        ]);
                                    }else{
                                        return view('content.student.apply-completion-letter', [
                                            'project'=>$project,
                                            'projectStatus'=>$projectStatus,
                                        ]);
                                    }
                                }else{
                                    return view('content.student.apply-completion-letter', [
                                        'project'=>$project,
                                        'projectStatus'=>$projectStatus,
                                    ]);
                                }
                            }else{
                                return view('content.student.apply-journal', [
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

    public function save(Request $request)
    {   
        $user = Auth::user();

        if($user){
            $project = trim($request->project_id);
            
            if (!$project ) {
                return redirect()->back()->withError('Completion request could not be attached!')->withInput();
            }

            $existingUser = Completion::where('project', $project)->first();
            
            $user_id = $user->id;
            
            if ($existingUser) {
                return redirect()->back()->withError('You have already  requested for your letter. You cannot request twice')->withInput();
            }

            DB::beginTransaction();

            try {

                $newCompletion = new Completion();

                $newCompletion->project = $request->project_id;
                $newCompletion->status = 1;
                
                $newCompletion->save();

                //project id
                $project_id = $request->project_id;
                Project::where('id',$request->project_id)->update(['stage'=>'7']);
                $date = date('U');

                DB::commit();
                return redirect()->intended(route('student-completion-letter'))->withSuccess('Application request successful')->withInput();
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->withError('An error occurred while processing your request. [' . $e->getMessage() . ']')->withInput();
            }
        }else{
            return route('login');
        }
        
    }
}
