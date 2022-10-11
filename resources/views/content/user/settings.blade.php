@extends('layouts/contentNavbarLayout')

@section('title', 'Profile settings')

@section('page-script')
<script src="{{asset('assets/js/settings.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Account /</span> Settings
</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item"><a class="nav-link" href="{{route('account-profile')}}"><i class="bx bx-bell me-1"></i> Profile</a></li>
      <li class="nav-item"><a class="nav-link active" href="{{route('account-settings')}}"><i class="bx bx-user me-1"></i> Settings</a></li>
    </ul>
    <div class="card mb-4">
      <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <form action="{{route('profileupdate')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
               @if( $menuDetails[0]['User']->avater == NULL )
                  <img src="{{ asset('storage/assets/img/avaters/avater.png') }}"  alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
               @else
                <img src="{{ asset('storage/assets/img/avaters/'.$user->avater) }}"  alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
               @endif
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input type="file" id="upload" name="profilephoto" class="account-file-input" hidden accept=" image/jpg" />
              </label>
              <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                <i class="bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>

              <p class="text-muted mb-0">Allowed JPG only. Max size of 800K</p>
            </div>
          </div>
        </div>
        <hr class="my-0">
        <div class="card-body">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="first_name" class="form-label">{{ $user->first_name.' '.$user->last_name }}</label>
              <input class="form-control" type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" autofocus />
            </div>
            <div class="mb-3 col-md-6">
              <label for="last_name" class="form-label">Last Name</label>
              <input class="form-control" type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input class="form-control" type="text" id="email" name="email" value="{{ $user->email }}" placeholder="your.name@example.com" />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="phone">Phone Number</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text">US (+26)</span>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="0777000000" />
              </div>
            </div>
            <div class="mb-3 col-md-6">
              <label for="school" class="form-label">School</label>
              <select class="form-control" id="school" name="school" required onchange="departmentChange(this.value);">
                <option value="">Choose school</option>
                @foreach($schools as $school)
                  @if($school->id == $user->school)
                  <option value="{{ $school->id }}" selected>{{ $school->name}}</option>
                  @else
                  <option value="{{ $school->id }}">{{ $school->name}}</option>
                  @endif
                @endforeach 
              </select>
            </div>
            <div class="mb-3 col-md-6"  id="department-container">
              <label for="department" class="form-label">Department</label>
              <select class="form-control" id="department" name="department" required>
                <option value="">Choose department</option>
                @foreach($departments as $department)
                  @if($department->id == $user->department)
                  <option value="{{ $department->id }}" selected>{{ $department->name}}</option>
                  @else
                  <option value="{{ $department->id }}">{{ $department->name}}</option>
                  @endif
                @endforeach 
              </select>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
          </div>
        </form>
      </div>
      <!-- /Account -->
    </div>
    @if($status->name == "Pending")
      <div class="card">
        <h5 class="card-header">Delete Account</h5>
        <div class="card-body">
          <div class="mb-3 col-12 mb-0">
            <div class="alert alert-warning">
              <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
              <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
            </div>
          </div>
          <form method="post" action="{{route('profiledelete')}}">
            {{ csrf_field() }}
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="accountDeactivation" id="accountDeactivation" required/>
              <label class="form-check-label" for="accountDeactivation">I confirm my account deactivation</label>
            </div>
            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
          </form>
        </div>
      </div>
    @endif
  </div>
</div>
<script type="text/javascript">

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
