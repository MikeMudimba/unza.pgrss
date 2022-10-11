@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Forgot Password -->
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

          <form id="formAuthentication" class="mb-3" action="{{ url('/auth/reset') }}" method="POST">
            {{ csrf_field()}} 
            <div class="mb-3">
              <label for="email" class="form-label">ID</label>
              <input type="text" class="form-control" id="email" name="id" placeholder="Enter your staff or student ID" autofocus>
            </div>
            <button class="btn btn-success d-grid w-100">Send Reset Link</button>
          </form>
          <div class="text-center">
            <a href="{{url('auth/login')}}" class="d-flex align-items-center justify-content-center">
              <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
              Back to login
            </a>
          </div>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
