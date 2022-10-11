@extends('layouts/contentNavbarLayout')

@section('title', 'Completion letter')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student /</span> Completion letter
</h4>

@include('content.form-layout.error_messages')
<div class="col-xl-12">
  <div class="nav-align-top mb-4">
    <div class="tab-content" style="background: transparent;padding:0;box-shadow:none;border:0px;">
      <div class="tab-pane fade show active" id="navs-pills-justified-submission" role="tabpanel">
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4" >
              <h5 class="card-header">Your letter of completion</h5>
              <hr class="my-0">
              <div class="card-body" id="print-me" style="position:relative;display:inline-block;text-align:center;">
                @if($status->name == "Approved")
                <div class="container" style="text-align:center;border: 10px inset green; width: 740px; vertical-align: middle;margin: 0 auto;padding:0;">
                  <div class="container" style="border: 10px outset green; width: 720px;">
                        </br></br>
                        <div style="width:100%;">
                          <span class="app-brand-logo demo">
                            <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="logo" style="margin:5px auto;display:inline-block;height:140px;">
                          </span>
                        </div>
                        </br><div class="logo" style="color: green;text-align:center;font-size:28px;">
                          The University of Zambia
                      </div>
                      <div class="logo" style="color: black;text-align:center;">
                          <strong>{{ $school->name }}</strong>
                      </div>
                      <div class="logo" style="color: black;text-align:center;">
                          {{ $department->name }}
                      </div></br></br>
                      <div class="logo" style="color: #999;text-align:center;">
                          {{ $programme->name }}
                      </div>

                      <div class="marquee" style="color: green; font-size: 48px; margin: 20px;">
                          Certificate of Completion
                      </div>

                      <div class="assignment" style="margin: 20px;">
                          This certificate is presented to
                      </div>

                      <div class="assignment" style="margin: 20px;">
                          {{ $user->number }}
                      </div>
                      <div class="person" style="border-bottom: 2px solid black; font-size: 32px; font-style: italic; margin: 20px auto; width: 400px;">
                          {{ $user->first_name.' '.$user->last_name }}
                      </div>

                      <div class="reason" style="margin: 20px;">
                          For successfully defending his dissertation and publishing a journal in<br/>
                          <strong>{{ $project->name }}</strong>
                          </br></br>
                          For the year {{ $intake->name }}
                          </br></br>
                          And is currently awaiting graduation.
                          </br></br>
                          </br></br>
                      </div>
                  </div>
                </div>
                @else
                  Your letter of completion has not been approved yet. Current status is 

                  <div class="demo-inline-spacing">
                    <span class="badge bg-label-{{ $status->color }}">{{ $status->name }}</span>
                  </div>
                @endif
              </div>
              <!-- /Account -->
            </div>
            


            <div class="row">
            <!-- Button with Badges -->
              <div class="col-lg">
                <div class="card mb-4">
                  <h5 class="card-header"> Options </h5>
                  <div class="card-body">
                    <div class="col-4">
                      <div class="row gy-3">
                        <div class="col-sm-4">
                          <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-primary" onclick="printer('print-me')">
                              Print 
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="navs-pills-justified-comments" role="tabpanel">
      @foreach($comments as $comment)
        <div class="accordion mt-3" id="accordionExample">  
          <div class="card accordion-item active">
            <h2 class="accordion-header" id="headingOne">
              <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion{{ $comment->id }}" aria-expanded="false" aria-controls="accordionOne">
                {{ $comment->first_name.' '.$comment->last_name }}
              </button>
            </h2>

            <div id="accordion{{ $comment->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                {{ $comment->name }}
                </br></br>
                <i class='bx bx-calendar'></i>  &emsp; <font style="color:#ccc;">{{ $comment->date_made }}</font>
              </div>
            </div>
          </div>
        </div>
      @endforeach 
      </div>
    </div>
  </div>
</div>





@endsection
