@extends('Layouts.master')

@section('title', 'Add Task')


@section('content')


<div class="container">
    <form action="" method="" class="p-4">
        @csrf
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Task name</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="project"></label>
          <select name="" id="project" required>
            <option value="">Select a project</option>
            <option value="">Project1</option>
            <option value="">Project2</option>
            <option value="">Project3</option>
          </select>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Make top</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>



@endsection