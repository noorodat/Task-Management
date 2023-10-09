@extends('Layouts.master')

@section('title', 'Tasks')


@section('content')


<h1 class="text-center mt-3">Tasks</h1>

@if (count($tasks) > 0)
    <div class="tasks p-4">
        <form action="" class="p-4">
            <select name="" id="">
                <option value="">Select a project</option>
                <option value="">Project1</option>
                <option value="">Project2</option>
                <option value="">Project3</option>
            </select>
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
                        <a href="" class="btn btn-primary">Edit</a>
                        <a href="" class="btn btn-danger">Delete</a>
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



