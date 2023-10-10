@extends('Layouts.master')

@section('title', 'Tasks')


@section('content')


<h1 class="text-center mt-3">Tasks</h1>

@if (count($tasks) > 0)
    <div class="tasks p-4">
        <form action="{{ route('showTasksBasedOnProjects') }}" class="p-4" method="post">
            @csrf
            <label style="display: block" for="show-tasks">Projects</label>
            <select id="show-tasks" name="project">
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <button type="submit">Show Tasks</button>
        </form>
        <table id="table" class="draggable-table table table-dark table-hover text-center">
            <thead>
                <th>Task Name</th>
                <th>Project</th>
                <th>Priority</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                <tr id="{{$task->priority}}">
                    <td>{{$task->name}}</td>
                    <td>{{$task->project->name}}</td>
                    <td>{{$task->priority}}</td>
                    <td>
                        {{-- {{route('task.edit')}} --}}
                        <div class="actions d-flex justify-content-center gap-3">
                            <a href="{{route('task.edit', $task)}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('task.destroy', $task)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@else {
    <h3 class="text-center p-4 mt-4">You have no tasks</h3>
}
    
@endif


@endsection



