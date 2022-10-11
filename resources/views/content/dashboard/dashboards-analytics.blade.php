@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection
@php
  $date = date('U');
@endphp
<script type="text/javascript">var growthChartProgress = {{ $progress }};</script>
@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js?v=$date')}}"></script>
@endsection



@section('content')
<div class="row">
  @include('content.form-layout.error_messages')
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">

          

          <div class="card-body">
            <h5 class="card-title text-primary">{{ $greeting }} {{ $user->first_name }} 🎉</h5>
            <p class="mb-4">You have made <span class="fw-bold"> {{ $progress.'%' }} </span> progress on your research. Take the next step. Click {{ $next }} below.</p>

            <a href="{{ route($route) }}" class="btn btn-sm btn-outline-primary">{{ $next }}</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
          <div id="growthChart"></div>
          <div class="text-center fw-semibold pt-3 mb-2"> {{ $remaining_progress }}% remaining </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 order-1">
    <div class="row">
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">{{ $user_type->name }}</span>
            <h3 class="card-title mb-2">Account</h3>
            <small class="text-success fw-semibold"> {{ $userStatus->name }}</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/wallet-info.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Tutorials</span>
            <a href="{{ route($router) }}"><h3 class="card-title text-nowrap mb-1">Open</h3></a>
            <small class="text-success fw-semibold">To learn more</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Total Revenue -->
  <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col-md-8">
          <h5 class="card-header m-0 me-2 pb-3">Your details</h5>
          <div id="" class="px-2">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <tbody>
                <tr>
                  <th>Logged in as</th>
                  <td>{{ $user_type->name }}</td>
                </tr>
                <tr>
                  <th>Account status</th>
                  <td>
                      <span class="badge bg-label-{{ $userStatus->color }}">{{ $userStatus->name }}</span>
                  </td>
                </tr>
                <tr>
                  <th>Username</th>
                  <td>{{ $user->number }}</td>
                </tr>
                <tr>
                  <th>User names</th>
                  <td>{{ $user->first_name.' '.$user->last_name }}</td>
                </tr>
                <tr>
                  <th>School</th>
                  <td>{{ $school->name}}</td>
                </tr>
                <tr>
                  <th>Department</th>
                  <td>{{ $department->name }}</td>
                </tr>
                <tr>
                  <th>Programme</th>
                  <td>{{ $programme->name }}</td>
                </tr>
                <tr>
                  <th>Intake</th>
                  <td>{{ $intake->name }}</td>
                </tr>
                <tr>
              </tbody>
            </table>
          </div>
          </div>
        </div>
        <div class="col-md-4">
          <h5 class="card-header m-0 me-2 pb-3" style="text-align:center;">Research details</h5>

          <div class="table-responsive text-nowrap">
            <table class="table table-borderless">
              <tbody style="text-align:center;">
                <tr>
                  <td>
                    <div class="demo-inline-spacing">
                      <span class="badge bg-label-{{ $status->color }}">{{ $status->name }}</span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>{{ mb_strimwidth($project->name, 0, 150, "...") }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Total Revenue -->
  <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
    <div class="row">
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="d-block mb-1">Curremt stage</span>
            <h3 class="card-title text-nowrap mb-2">{{ $stage_ }} of 7</h3>
            <small class="text-danger fw-semibold"> {{ $stage }}</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="chart success" class="rounded">
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                  <a class="dropdown-item" href="{{ route($router) }}">View comments</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Feedback</span>
            <a href="{{ route($router) }}"><h3 class="card-title mb-2">{{ count($comments) }}</h3></a>
            <small class="text-success fw-semibold"> <i class='bx bxl-messenger'></i> Open comments </small>
          </div>
        </div>
      </div>
      <!-- </div>
    <div class="row"> -->
      <div class="col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
              <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                <div class="card-title">
                  <h5 class="text-nowrap mb-2">Supervisor details</h5>
                  @if($supervisor->id != 0)
                  <span class="badge bg-label-success rounded-pill">Supervisor assigned</span>
                  @else
                  <span class="badge bg-label-danger rounded-pill">Supervisor not assigned</span>
                  @endif
                </div>
                <div class="mt-sm-auto">
                  @if($supervisor->id != 0)
                  <small class="text-success text-nowrap fw-semibold"><i class='bx bx-phone'></i> {{ $supervisor->phone.' : '.$supervisor->email }}</small>
                  </br><h3 class="mb-0">{{ $supervisor->first_name.' '.$supervisor->last_name }}</h3>
                  @else
                  <small class="text-success text-nowrap fw-semibold"><i class='bx bx-phone'></i> </small>
                  </br><h3 class="mb-0">Pending</h3>
                  @endif
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
