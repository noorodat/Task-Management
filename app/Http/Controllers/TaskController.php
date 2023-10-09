<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('priority', 'asc')->get();
        return view('Task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('Task.add', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $taskCount = Task::count();
        $lastTask = Task::latest()->first();

        if($lastTask) {
            $priortry = $taskCount + 1;
        } else {
            $priortry = 1;
        }

        $request->validate([
            'task-name' => 'required|string',
            'project-name' => 'required',
        ]);

        Task::create([
            'name' => $request->input('task-name'),
            'priority' => $priortry,
            'project_id' => $request->input('project-name'),
        ]);

        flash()->addSuccess('Task added');

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('Task.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
