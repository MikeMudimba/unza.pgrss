@extends('layouts/contentNavbarLayout')

@section('title', 'Profile settings')

@section('page-script')
<script src="{{asset('assets/js/settings.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Account /</span> Profile
</h4>
@include('content.form-layout.error_messages')
<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item"><a class="nav-link active" href="{{route('account-profile')}}"><i class="bx bx-bell me-1"></i> Profile</a></li>
      <li class="nav-item"><a class="nav-link" href="{{route('account-settings')}}"><i class="bx bx-user me-1"></i> Settings</a></li>
    </ul>
    <div class="card mb-4">
      <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
              @if( $menuDetails[0]['User']->avater == NULL )
                  <img src="{{ asset('storage/assets/img/avaters/avater.png') }}"  alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
               @else
                <img src="{{ asset('storage/assets/img/avaters/'.$user->avater) }}"  alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
               @endif
          
          <div class="button-wrapper">
            <div class="demo-inline-spacing">
                <span class="badge bg-label-{{ $status->color }}">{{ $status->name }}</span>
            </div>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="firstName" class="form-label" style="font-weight:bold">{{ $user->first_name.' '.$user->last_name }}</label>
              </br>{{ $user->first_name }}
            </div>
            <div class="mb-3 col-md-6">
              <label for="lastName" class="form-label" style="font-weight:bold">Last Name</label>
              </br>{{ $user->last_name }}
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label" style="font-weight:bold">E-mail</label>
              </br>{{ $user->email }}
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="phoneNumber" style="font-weight:bold">Phone Number</label>
              </br>{{ $user->phone }}
            </div>
            <div class="mb-3 col-md-6">
              <label for="school" class="form-label" style="font-weight:bold">School</label>
                @foreach($schools as $school)
                  @if($school->id == $user->school)
                    </br>{{ $school->name}}
                  @endif
                @endforeach 
            </div>
            <div class="mb-3 col-md-6"  id="department-container">
              <label for="department" class="form-label" style="font-weight:bold">Department</label>
                @foreach($departments as $department)
                  @if($department->id == $user->department)
                    </br>{{ $department->name}}
                  @endif
                @endforeach 
            </div>
          </div>
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>
@endsection
