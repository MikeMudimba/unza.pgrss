@extends('layouts/contentNavbarLayout')

@section('title', 'Ethical Clearance')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Student /</span> Ethical Clearance
</h4>

@include('content.form-layout.error_messages')
<div class="col-xl-12">
  <div class="nav-align-top mb-4">
    <div class="col-xl-6">
      <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-submission" aria-controls="navs-pills-justified-home" aria-selected="true"><i class="tf-icons bx bx-receipt"></i> Submission </button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-comments" aria-controls="navs-pills-justified-messages" aria-selected="false"><i class="tf-icons bx bx-message-square"></i> Comments <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger">{{ count($comments) }}</span> </button>
        </li>
      </ul>
    </div>
    <div class="tab-content" style="background: transparent;padding:0;box-shadow:none;border:0px;">
      <div class="tab-pane fade show active" id="navs-pills-justified-submission" role="tabpanel">
        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4" id="print-me">
              <h5 class="card-header">Ethical Clearance Details</h5>
              <hr class="my-0">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody class="table-border-bottom-0" style="border:1px solid #eee;word-wrap: break-word;word-break:break-word;">
                      <tr>
                        <th>Status</th>
                        <td>
                          <div class="demo-inline-spacing">
                            <span class="badge bg-label-{{ $status->color }}">{{ $status->name }}</span>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th>Student No</th>
                        <td>{{ $user->number }}</td>
                      </tr>
                      <tr>
                        <th>Student names</th>
                        <td>{{ $user->first_name.' '.$user->last_name }}</td>
                      </tr>
                      <tr>
                        <th>Research name</th>
                        <td>{{ $project->name }}</td>
                      </tr>
                      @foreach($projectAttachments as $projectAttachment)
                        <tr>
                          <th>{{ $projectAttachment->name }}</th>
                          <td><a target="blank" href="{{ '../../storage/app/public/uploads/'.$projectAttachment->downlink }}">Download</a></td>
                        </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /Account -->
            </div>
            

            <!-- Extra Large Modal -->
            <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Update ethical clearance application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="update" method="POST" action="{{ url('/student/ethical-clearance/update') }}" enctype="multipart/form-data" >
                      {{ csrf_field()}}
                      <input type="hidden" value="{{ $project->id }}" name="project_id"/>
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <div class="card-body demo-vertical-spacing demo-only-element">
                              <div class="mb-3 col-md-12">
                          <label for="project" class="form-label">Application for ethical approval</label>
                          <div class="input-group">
                            <label class="input-group-text" for="inputGroupFile01">Mandetory</label>
                            <input required type="file" class="form-control" id="inputGroupFile01" name="file1">
                          </div>
                        </div> 
                        
                        <div class="mb-3 col-md-12">
                          <label for="project" class="form-label">Participant information sheet</label>
                          <div class="input-group">
                            <label class="input-group-text" for="inputGroupFile02">Mandetory</label>
                            <input required type="file" class="form-control" id="inputGroupFile02" name="file2">
                          </div>
                        </div> 

                        <div class="mb-3 col-md-12">
                          <label for="project" class="form-label">Ethical clearance form</label>
                          <div class="input-group">
                            <label class="input-group-text" for="inputGroupFile03">Mandetory</label>
                            <input required type="file" class="form-control" id="inputGroupFile03" name="file3">
                          </div>
                        </div> 
                          </div>
                        </div>
                      </div>
                    </div>

                    </br>
                    </br>
                  </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="document.getElementById('update').submit();" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>









            <!-- Extra Large Modal -->
            <div class="modal fade" id="exLargeModalRetract" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel4">Retract submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                  <form id="retract" method="POST" action="{{ url('/student/ethical-clearance/delete') }}" enctype="multipart/form-data" >
                    {{ csrf_field()}}
                    <input type="hidden" value="{{ $project->id }}" name="project_id"/>
                    Are you sure you want to retract your submission?
                    </br>
                    </br>
                  </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="document.getElementById('retract').submit();" class="btn btn-danger">Retract</button>
                  </div>
                </div>
              </div>
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
                        @if( strtolower($status->name)=="pending" )
                        <div class="col-sm-4">
                          <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exLargeModal">
                              Update
                            </button>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="demo-inline-spacing">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exLargeModalRetract">
                              Retract
                            </button>
                          </div>
                        </div>
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
