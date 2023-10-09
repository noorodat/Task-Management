@extends('Layouts.master')

@section('title', 'Add Project')


@section('content')


<div class="container">
    <form action="{{route('project.store')}}" method="POST" class="p-4">
        @csrf
        <div class="mb-3">
          <label for="projectName" class="form-label">Project name</label>
          <input name="projectName" type="text" class="form-control" id="projectName">
          @error('projectName')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
</div>



@endsection