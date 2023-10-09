@extends('Layouts.master')

@section('title', 'Add Task')


@section('content')


<div class="container">
  @if (count($projects) > 0)
      <form action="{{ route('task.store') }}" method="POST" class="p-4">
          @csrf
          <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Task name</label>
              <input name="task-name" required type="text" class="form-control" id="exampleInputEmail1">
              @error('task-name')
              <div class="alert alert-danger mt-2">{{ $message }}</div>
              @enderror
          </div>
          <div class="mb-3">
              <label for="project" class="form-label">Project</label>
              <select name="project-name" id="project" required>
                <option value="" disabled>Select a project</option>
                @foreach ($projects as $project)
                    <option value="{{$project->id}}">{{$project->name}}</option>
                @endforeach
              </select>
              @error('project-name')
              <div class="alert alert-danger mt-2">{{ $message }}</div>
              @enderror
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
@else
  <div class="msg text-center mt-4 p-4">
    <h3>You don't have any projects yet. Please create a project to start adding tasks.</h3>
    <a class="btn btn-primary mt-2" href="{{route('project.create')}}">Add project</a>
  </div>
@endif

</div>



@endsection