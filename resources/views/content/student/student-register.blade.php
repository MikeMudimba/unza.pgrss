@extends('layouts/contentNavbarLayout')

@section('title', 'Register research')

@section('page-script')
<script src="{{asset('assets/js/student-register.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student /</span> Register
</h4>

@include('content.form-layout.error_messages')
<div class="row">
  <div class="col-md-12">
    
    <div class="card mb-4">
      <h5 class="card-header">Research Registration Form </h5>
      <hr class="my-0">
      <div class="card-body">
        @if($userStatus->name != "Approved")
          Your user account has not yet been approved. You can only register once your account has been approved by your department.
          </br></br>
          Your current status is:
          <div class="demo-inline-spacing">
            <span class="badge bg-label-{{ $userStatus->color }}">{{ $userStatus->name }}</span>
          </div>
        @else
          <form id="formRegister" method="POST" action="{{ url('/student/register/save') }}" enctype="multipart/form-data" >
            {{ csrf_field()}}
            <div class="row">
              <div class="col-6">
                <div class="card">
                  <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Research Name</label>
                      <input class="form-control" required type="text" id="project" name="project" placeholder="Your project name " autofocus />
                    </div>
                    <div class="mb-3 col-md-12">
                      <label for="programme" class="form-label">Programme</label>
                      <select class="form-control" id="programme" name="programme" required onchange="departmentChange(this.value);">
                        <option value="">Choose programme</option>
                        @foreach($programmes as $programme)
                          <option value="{{ $programme->id }}">{{ $programme->name}}</option>
                        @endforeach 
                      </select>
                    </div>
                    <div class="mb-3 col-md-12">
                      <label for="level" class="form-label">Level</label>
                      <select class="form-control" id="level" name="level" required onchange="departmentChange(this.value);">
                        <option value="">Choose level</option>
                        @foreach($levels as $level)
                          <option value="{{ $level->id }}">{{ $level->name}}</option>
                        @endforeach 
                      </select> 
                    </div> 
                    <div class="mb-3 col-md-12">
                      <label for="mode" class="form-label">Mode of training</label>
                      <select class="form-control" id="mode" name="mode" required onchange="departmentChange(this.value);">
                        <option value="">Choose mode of training</option>
                        @foreach($modes as $mode)
                          <option value="{{ $mode->id }}">{{ $mode->name}}</option>
                        @endforeach 
                      </select>
                    </div>
                    <div class="mb-3 col-md-12">
                      <label for="intake" class="form-label">Intake</label>
                      <select class="form-control" id="intake" name="intake" required onchange="departmentChange(this.value);">
                        <option value="">Choose intake</option>
                        @foreach($intakes as $intake)
                          <option value="{{ $intake->id }}">{{ $intake->name}}</option>
                        @endforeach 
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card">
                  <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Start Date</label>
                      <input class="form-control" required type="date" value="" id="start_date" name="start_date"/>
                    </div>
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Start Date</label>
                      <input class="form-control" required type="date" value="" id="end_date" name="end_date"/>
                    </div>
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Project proposal</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile01">Mandetory</label>
                        <input required type="file" class="form-control" id="inputGroupFile01" name="file1">
                      </div>
                    </div> 
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Gantt chart and timeline</label>
                      <div class="input-group">
                      <label class="input-group-text" for="inputGroupFile03">Mandetory</label>
                        <input required type="file" class="form-control" id="inputGroupFile03" name="file2">
                      </div>
                    </div> 
                    <div class="mb-3 col-md-12">
                      <label for="project" class="form-label">Data collection tools</label>
                      <div class="input-group">
                        <label class="input-group-text" for="inputGroupFile02">Mandetory</label>
                        <input required type="file" class="form-control" id="inputGroupFile02" name="file3">
                      </div>
                      
                    </div> 

                    
                  </div>
                </div>
              </div>
            </div>

            </br>
            </br>
            
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Request registration</button>
            </div>
          </form>
        @endif
        
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>
@endsection
