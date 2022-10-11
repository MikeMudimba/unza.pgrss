@extends('layouts/blankLayout')

@section('title', 'UNZA Postgraduate Project Submission System')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
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

          <form id="formAuthentication" class="mb-3" action="{{ url('/auth/signin') }}" method="POST">
            {{ csrf_field()}}
            <div class="mb-3">
              <label for="email" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="email" name="number" placeholder="Enter your student ID" autofocus required>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
                <a href="{{url('auth/forgot-password')}}">
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-success d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>

          <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('auth/register')}}">
              <span>Create an account</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
