@extends('layouts.app')

@section('content')
@if (session('message'))
    <div class="container">
        <div class="alert alert-success col-md-3">
            {{ session('message') }}
        </div>
    </div> 
@endif
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <form method="POST" id="updateForm" action="{{ route('project.update', $project->id) }}">
                @csrf
                @method('PUT')
                <h5>Project Details</h5>
                <div class="form-group">
                    <label for="name">Project Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $project->name }}" required
                    @if(!$isCreator)
                        disabled
                    @endif>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ $project->description }}"
                    @if(!$isCreator)
                        disabled
                    @endif>
                </div>

                <div class="form-group">
                    <label for="completedJobs">Completed Jobs:</label>
                    <input type="text" class="form-control" id="completedJobs" name="completedJobs" value="{{ $project->completed_jobs }}">
                </div>

                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" min="0" step="0.01" class="form-control" name="cost" id="cost" required value="{{ $project->cost }}"
                    @if(!$isCreator)
                        disabled
                    @endif>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-auto">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" class="form-control" name="startDate" required value="{{ $project->start_time }}"
                            @if(!$isCreator)
                                disabled
                            @endif>
                            </input>
                        </div>
                        <div class="col-md-auto">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" class="form-control" name="endDate" value = "{{ $project->end_time }}"
                            @if(!$isCreator)
                                disabled
                            @endif>
                            </input>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="duplicateContainer">Members</label>
                    <div id="duplicateContainer">
                        @foreach ($project->users as $user)
                        <div class="p-1">
                            <select name="users[]" id="userDropdown" class="form-control form-control-sm"
                            @if ($user->id === $project->creator->id || !$isCreator)
                                disabled
                            @endif>
                                <option value="{{ $user->id }}" selected hidden>{{ $user->name }}</option>
                                <option value="">None</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>   
                        @endforeach
                        @if ($isCreator)
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
                        @endif

                    </div>
                    @if ($isCreator)
                    <button type="button" id="duplicateButton">Add more Members</button>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary mt-4">Update</button>
            </form>
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

