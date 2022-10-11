@extends('layouts/contentNavbarLayout')

@section('title', 'Supervisor projects')

@section('page-script')

@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Supervisor /</span> Projects
</h4>

<div class="row">
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">Research Projects</h5>
    <div class="table-responsive">
      <table class="table" style="margin:0 0 100px 0;">
        <thead>
          <tr>
            <th>USER</th>
            <th>ID</th>
            <th>NAMES</th>
            <th>RESEARCH</th>
            <th>STATUS</th>
            <th>STAGE</th>
            <th>SUPERVISOR</th>
            <th>ASSESSOR</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach($projects as $project)
          <tr>
            
            <td>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{ $project->owner_details->first_name.' '.$project->owner_details->last_name }}">
                  @if( $project->owner_details->avater != "" )
                    <img src="{{asset('storage/assets/img/avaters/'.$project->owner_details->avater )}}" alt="Avatar" class="rounded-circle">
                  @else
                  <img src="{{asset('storage/assets/img/avaters/avater.png' )}}" alt="Avatar" class="rounded-circle">
                  @endif
                </li>
              </ul>
            </td>
            
            <td><i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>{{  $project->owner_details->number }}</strong></td>
            <td>  
              {{ $project->owner_details->first_name.' '.$project->owner_details->last_name }}
            </td>
            <td>
              {{ $project->project_details->name }}
            </td>
            <td><span class="badge bg-label-{{ $project->project_details->color }} me-1">{{ $project->project_details->status }}</span></td>
            <td>
              {{ $project->project_details->stage }} of 7
            </td>
            @if( property_exists($project->supervisor_details, "first_name") )
            <td>
              {{ $project->supervisor_details->first_name.' '.$project->supervisor_details->last_name }}
            </td>
            @else
            <td>
              Not assigned
            </td>
            @endif

            @if( property_exists($project->assessor_details, "first_name") )
            <td>
              {{ $project->assessor_details->first_name.' '.$project->assessor_details->last_name }}
            </td>
            @else
            <td>
              Not assessed
            </td>
            @endif
            <td>
              <a class="dropdown-item" href="{{ route('project', $project->project_details->id) }}"><i class="bx bx-edit-alt me-2"></i>View</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
<!--/ Basic Bootstrap Table -->
</div>
@endsection
