@extends('Layouts.master')

@section('title', 'Edit Task')


@section('content')


<div class="container">
    <form action="{{route('task.update', $task)}}" method="POST" class="p-4">
        @csrf
        @method('PATCH')
        <div class="mb-3">
          <label for="task-name" class="form-label">Task name</label>
          <input name="taskName" value="{{$task->name}}" type="text" class="form-control" id="task-name">
        </div>
        <div class="mb-3">
          <label for="project"></label>
          <select name="projectID" id="project" required>
            <option value="{{$task->project->id}}">{{$task->project->name}}</option>
            @foreach ($projects as $project)
                @if ($project->id !== $task->project->id)
                <option value="{{$project->id}}">{{$project->name}}</option>
                @endif
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>



@endsection