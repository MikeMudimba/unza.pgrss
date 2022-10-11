@extends('layouts/contentNavbarLayout')

@section('title', 'Completion letter')
 
@section('page-script')
<script src="{{asset('assets/js/student-register.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student /</span> Completion letter
</h4>

@include('content.form-layout.error_messages')
<div class="row">
  <div class="col-md-12">
     
    <div class="card mb-4">
      <h5 class="card-header"> Request completion letter </h5>
      <hr class="my-0">
      <div class="card-body">
        @if($projectStatus->name != "Approved")
          Your Journal has not yet been approved. You can only claim your letter of once your seminer week submission has been approved by your department.
          </br></br>
          Your current status is:
          <div class="demo-inline-spacing">
            <span class="badge bg-label-{{ $projectStatus->color }}">{{ $projectStatus->name }}</span>
          </div>
        @else
          <form id="formRegister" method="POST" action="{{ url('/student/completion-letter/save') }}" enctype="multipart/form-data" >
            {{ csrf_field()}}
            <input type="hidden" value="{{ $project->id }}" name="project_id"/>
             
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Request for your letter of completion</button>
            </div>
          </form>
        @endif
        
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>
@endsection
