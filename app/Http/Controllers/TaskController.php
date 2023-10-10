<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        $tasks = Task::orderBy('priority', 'asc')->get();
        return view('Task.index', compact('tasks', 'projects'));
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

        if ($lastTask) {
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

    public function updatePriority(Request $request)
    {
        $swappedPriority = $request->input('swappedPriority');
        $draggedPriority = $request->input('draggedPriority');
    
        $recordWithSwappedPriority = Task::where('priority', $swappedPriority)->first();
        $recordWithDraggedPriority = Task::where('priority', $draggedPriority)->first();
    
        // Get the records in the range on -
        $recordsInRangeOnSub = Task::where('priority', '>', $draggedPriority)
        ->where('priority', '<=', $swappedPriority)
        ->get();

        // Get the records in the range on +
        $recordsInRangeOnAdd = Task::where('priority', '<', $draggedPriority)
        ->where('priority', '>=', $swappedPriority)
        ->get();
    
        $operation = $draggedPriority > $swappedPriority ? 'add' : 'sub';

        $recordWithDraggedPriority->update(['priority' => $swappedPriority]);


        if ($operation === 'add') {
            $recordsInRangeOnAdd->each(function ($record) {
                $record->increment('priority', 1);
            });
        } elseif ($operation === 'sub') {
            $recordsInRangeOnSub->each(function ($record) {
                $record->decrement('priority', 1);
            });
        }
    
        return response()->json(['message' => 'Priority updated successfully']);
    }
    
    public function showTasksBasedOnProjects(Request $request)
    {
        $projectId = $request->input('project');
        $projects = Project::all();

        if($projectId === null) {
            flash()->addError('Select a project to show');
            return redirect()->back();
        }
    
        // Use Eloquent to retrieve tasks for the selected project
        $tasks = Task::where('project_id', $projectId)->get();
    
        // You can pass $tasks to your view to display them
        return view('Task.index', compact('tasks', 'projects'));
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
        $projects = Project::all();
        return view('Task.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task_name = $request->input('taskName');

        $project_id = $request->input('projectID');

        $task->update([
            'name' => $task_name,
            'project_id' => $project_id,
        ]);

        flash()->addSuccess("Task updated");

        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $deletedPriority = $task->priority;
    
        // Delete the task
        $task->delete();
    
        // Update the priority (decrease by 1) for all the records below the deleted task
        Task::where('priority', '>', $deletedPriority)
            ->decrement('priority');
    
        flash()->addSuccess('Task Deleted');

        return redirect()->back();
    }

    
}
