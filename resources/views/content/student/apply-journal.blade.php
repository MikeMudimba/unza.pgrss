@extends('layouts/contentNavbarLayout')

@section('title', 'Journal')
 
@section('page-script')
<script src="{{asset('assets/js/student-register.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student /</span> Journal
</h4>

@include('content.form-layout.error_messages')
<div class="row">
  <div class="col-md-12">
     
    <div class="card mb-4">
      <h5 class="card-header"> Journal Submission Form  </h5>
      <hr class="my-0">
      <div class="card-body">
        @if($projectStatus->name != "Approved")
          Your Seminer Week submission has not yet been approved. You can only submit your Journal once your dissertation has been approved by your department.
          </br></br>
          Your current status is:
          <div class="demo-inline-spacing">
            <span class="badge bg-label-{{ $projectStatus->color }}">{{ $projectStatus->name }}</span>
          </div>
        @else
          <form id="formRegister" method="POST" action="{{ url('/student/journal/save') }}" enctype="multipart/form-data" >
            {{ csrf_field()}}
            <div class="row">
            <input type="hidden" value="{{ $project->id }}" name="project_id"/>
              <div class="col-12">
                <div class="card">
                  <div class="card-body demo-vertical-spacing demo-only-element">
                    
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Journal</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile01">Mandetory</label>
                        <input required type="file" class="form-control" id="inputGroupFile01" name="file1" required>
                      </div>
                    </div> 
                  </div>
                </div>
              </div>
            </div>

            </br>
            </br>
            
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Apply</button>
            </div>
          </form>
        @endif
        
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>
@endsection
