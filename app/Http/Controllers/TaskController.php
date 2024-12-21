<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate();
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $taskStatuses = TaskStatus::all();
            $users = User::all();
            return view('task.create',
                [
                    'task_statuses' => $taskStatuses,
                    'users' => $users,
                ]);
        }
        return abort(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $dataFill = $request->validate([
            'name' => 'required|unique:tasks|max:20',
            'description' => 'max:100',
            'status_id' => 'required',
            'assigned_to_id' => '',
        ]);
        $task = new Task();
        $task->fill($dataFill);
        $task->created_by_id = Auth::id();
        $task->save();
        return redirect()
            ->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (Auth::check()) {
            $taskStatuses = TaskStatus::all();
            $users = User::all();
            return view('task.edit',
                [
                    'task' => $task,
                    'task_statuses' => $taskStatuses,
                    'users' => $users,
                ]);
        }
        return abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $dataFill = $request->validate([
            'name' => "required|max:20|unique:tasks,name,{$task->id}",
            'description' => 'max:100',
            'status_id' => 'required',
            'assigned_to_id' => '',
        ]);
        $task->fill($dataFill);
        $task->save();
        return redirect()
            ->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Auth::check()) {
            $task->delete();
            return redirect()->route('task.index');
        }
        return abort(401);
    }
}
