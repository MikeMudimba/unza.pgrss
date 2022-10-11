@extends('layouts/blankLayout')

@section('title', 'Register')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="container" style="text-align:center;margin: 0 0 30px 0;">
            <a class="navbar-brand" href="#"><img src="{{ asset('assets/img/icons/logo.svg') }}" alt="logo" style="margin:5px auto;display:inline-block;height:100px;"></a>
            <h4 class="mb-2"> {{config('variables.templateName')}} </h4>
            <p class="mb-4"> Postgraduate Project Submission System</p>
          </div>
          <!-- /Logo -->

          @include('content.form-layout.error_messages')

          <form id="formAuthentication" class="mb-3" action="{{ url('/auth/signup') }}" method="POST">
            {{ csrf_field()}}
            <div class="form-row">
              <div class="col">
                <div class="mb-3">
                  <label for="username" class="form-label">User Type</label>
                  <div class="input-group">
                    <button id="student" onclick="userType('student');" class="btn btn-outline-secondary" type="button" style="width: calc(50% - 2px);">Student</button>
                    <button id="staff" onclick="userType('staff');" class="btn btn-outline-secondary" type="button" style="width: calc(50% - 2px);">Staff</button>
                  </div>
                  <input type="hidden" value="1" name="type" id="type"/>
                </div>
              </div>

              <div class="col">
                <div class="mb-3">
                  <label for="username" class="form-label" id="typeLabel">Student ID</label>
                  <input type="text" class="form-control" id="username" name="id" placeholder="Enter your student ID" autofocus required>
                </div>
                <div class="mb-3">
                  <label for="first_name" class="form-label">Given names</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your given names" required>
                </div>
                <div class="mb-3">
                  <label for="sur_name" class="form-label">Sur name</label>
                  <input type="text" class="form-control" id="sur_name" name="sur_name" placeholder="Enter your sur name" required>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone (WhatsApp)</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">US (+26)</span>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter your phone number" required/>
                  </div>
                </div>
              </div>
              <div class="col">
              <div class="mb-3">
                  <label for="school" class="form-label">School</label>
                  <select class="form-control" id="school" name="school" required onchange="departmentChange(this.value);">
                  <option value="">Choose school</option>
                  @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name}}</option>
                  @endforeach 
                  </select>
                </div>
                <div class="mb-3" id="department-container">
                  <label for="department" class="form-label">Department</label>
                  <select class="form-control" id="department" name="department" required disabled>
                    <option value="">Choose department first</option>
                  </select>
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="confirmpassword">Confirm Password</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="confirmpassword" class="form-control" name="confirmPassword" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
              </div>
            </div>
            

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
                <label class="form-check-label" for="terms-conditions">
                  I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>
            <button class="btn btn-success d-grid w-100">
              Sign up
            </button>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="{{url('auth/login')}}">
              <span>Sign in instead</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
</div>
<script type="text/javascript">
  function userType(type){
    if(type == "student"){
      document.getElementById('typeLabel').innerHTML = "Student ID";
      document.getElementById('username').placeholder = "Enter your student ID";
      document.getElementById('username').value = "";

      document.getElementById('student').style.background = "#999";
      document.getElementById('staff').style.background = "#fff";
      document.getElementById('student').style.color = "#fff";
      document.getElementById('staff').style.color = "#999 ";

      document.getElementById('type').value = 1;
    }else{
      document.getElementById('typeLabel').innerHTML = "Employee ID";
      document.getElementById('username').placeholder = "Enter your employee ID";
      document.getElementById('username').value = "";

      document.getElementById('student').style.background = "#fff";
      document.getElementById('staff').style.background = "#999 ";
      document.getElementById('student').style.color = "#999";
      document.getElementById('staff').style.color = "#fff ";

      document.getElementById('type').value = 2;
    }
  }

  function departmentChange(schoolId)
  {
    var departments = JSON.parse(JSON.stringify({!! json_encode($departments) !!}));
    var returnString = "<label for='department' class='form-label'>Department</label><select class='form-control' id='department' name='department' required>";
    returnString = returnString+"<option value=''>Choose department</option>";
    departments.forEach(function( value, index ){
      if(departments[index]['school'] == schoolId){
        returnString = returnString+"<option value='"+departments[index]['id']+"'>"+departments[index]['name']+"</option>";
      }
    });
      
    returnString = returnString = returnString+"</select>";
    document.getElementById("department-container").innerHTML = returnString;
  }
</script>
@endsection

