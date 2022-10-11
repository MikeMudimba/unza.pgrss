@extends('layouts/contentNavbarLayout')

@section('title', 'Ethical Clearance')
 
@section('page-script')
<script src="{{asset('assets/js/student-register.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student /</span> Research Proposal
</h4>

@include('content.form-layout.error_messages')
<div class="row">
  <div class="col-md-12">
    
    <div class="card mb-4">
      <h5 class="card-header"> Research Proposal Application Form  </h5>
      <hr class="my-0">
      <div class="card-body">
        @if($projectStatus->name != "Approved")
          Your ethical clearance application has not yet been approved. You can only apply for research proposal once your ethical clearance has been approved by your department.
          </br></br>
          Your current status is:
          <div class="demo-inline-spacing">
            <span class="badge bg-label-{{ $projectStatus->color }}">{{ $projectStatus->name }}</span>
          </div>
        @else
          <form id="formRegister" method="POST" action="{{ url('/student/research-proposal/save') }}" enctype="multipart/form-data" >
            {{ csrf_field()}}
            <div class="row">
            <input type="hidden" value="{{ $project->id }}" name="project_id"/>
              <div class="col-12">
                <div class="card">
                  <div class="card-body demo-vertical-spacing demo-only-element">
                    
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">One page summary</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile01">Mandetory</label>
                        <input required type="file" class="form-control" id="inputGroupFile01" name="file1" required>
                      </div>
                    </div> 
                    
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Three page summary</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile02">Optional</label>
                        <input required type="file" class="form-control" id="inputGroupFile02" name="file2">
                      </div>
                    </div> 

                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Five page summary</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile03">Optional</label>
                        <input required type="file" class="form-control" id="inputGroupFile03" name="file3">
                      </div>
                    </div> 

                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Powerpoint presentation</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile03">Optional</label>
                        <input required type="file" class="form-control" id="inputGroupFile03" name="file4">
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
