@extends('layouts.app')

@section('content')
@if (session('message'))
    <div class="container">
        <div class="alert alert-success col-md-3">
            {{ session('message') }}
        </div>
    </div> 
@endif
<div class="container mt-5">
    <div class="row mb-4">
      <div class="col-md-6">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add Project</button>
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-12">
        <h2>Your Projects</h2>
        <div class="row" id="projectList">
          <!-- Project cards will be dynamically added here -->
          @foreach ($createdProjects as $project)
            <div class="p-3">
              <h3>{{ $project }}</h3>
            </div>
          @endforeach
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form id="addProjectForm" action="project" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group">
              <label for="name">Name*</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="completedJobs">Completed Jobs</label>
                <textarea class="form-control" id="completedJobs" name="completedJobs" rows="3"></textarea>
            </div>

            <div class="form-group">
              <label for="cost">Cost*</label>
              <input type="number" min="0" step="0.01" class="form-control" name="cost" id="cost" required>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="startDate">Start Date*</label>
                        <input type="date" id="startDate" class="form-control" name="startDate" required></input>
                    </div>
                    <div class="col-6">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" class="form-control" name="endDate"></input>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="user">Add Members</label>
                <div id="duplicateContainer">
                    <div id="originalElement">
                        <div class="p-1">
                            <select name="users[]" id="userDropdown" class="form-control form-control-sm">
                                <option value="" disabled selected hidden>Select Member...</option>
                                <option value="">None</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>      
                    </div>
                </div>
                <button type="button" id="duplicateButton">Add more Members</button>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Submit</button>
          </form>
        </div>
      </div>
    </div>
</div>

<script>
    var duplicateButton = document.getElementById('duplicateButton');
    var duplicateContainer = document.getElementById('duplicateContainer');
    var index = 1;

    duplicateButton.addEventListener('click', function() {
        var originalSelect = document.querySelector('#originalElement div');
        var clonedSelect = originalSelect.cloneNode(true);
        duplicateContainer.appendChild(clonedSelect);
        index++;
    });
</script>
@endsection

