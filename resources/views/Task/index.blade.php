@extends('Layouts.master')

@section('title', 'Tasks')


@section('content')


<h1 class="text-center mt-3">Tasks</h1>

<div class="tasks p-4">
    <table id="table" class="draggable-table table table-dark table-hover text-center">
        <thead>
            <th>Task Name</th>
            <th>Craeted at</th>
            <th>Priority</th>
            <th>Action</th>
        </thead>
        <tbody>
            <tr>
                <td>Task1</td>
                <td>Today</td>
                <td>1</td>
                <td>
                    <a href="" class="btn btn-primary">Edit</a>
                    <a href="" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <tr>
                <td>Task2</td>
                <td>Today</td>
                <td>2</td>
                <td>
                    <a href="" class="btn btn-primary">Edit</a>
                    <a href="" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <tr>
                <td>Task3</td>
                <td>Today</td>
                <td>3</td>
                <td>
                    <a href="" class="btn btn-primary">Edit</a>
                    <a href="" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <tr>
                <td>Task4</td>
                <td>Today</td>
                <td>4</td>
                <td>
                    <a href="" class="btn btn-primary">Edit</a>
                    <a href="" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <tr>
                <td>Task5</td>
                <td>Today</td>
                <td>5</td>
                <td>
                    <a href="" class="btn btn-primary">Edit</a>
                    <a href="" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>


@endsection



