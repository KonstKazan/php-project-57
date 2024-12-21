<?php

namespace App\Http\Controllers;

use App\Models\Label;
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
            $labels = Label::all();
            return view('task.create',
                [
                    'task_statuses' => $taskStatuses,
                    'users' => $users,
                    'labels' => $labels,
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
        $labelsReq = $request->input('labels');
        $labels = Label::find($labelsReq);
        $task = new Task();
        $task->fill($dataFill);
        $task->created_by_id = Auth::id();
        $task->save();
        $task->labels()->attach($labels);
        return redirect()
            ->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $labels = $task->labels;
        return view('task.show',
            [
                'task' => $task,
                'labels' => $labels,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (Auth::check()) {
            $taskStatuses = TaskStatus::all();
            $users = User::all();
            $labels = Label::all();
            return view('task.edit',
                [
                    'task' => $task,
                    'task_statuses' => $taskStatuses,
                    'users' => $users,
                    'labels' => $labels,
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
        $labelsReq = $request->input('labels');
        $labels = Label::find($labelsReq);
        $task->labels()->sync($labels);
        return redirect()
            ->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Auth::check()) {
            $task->labels()->detach();
            $task->delete();
            return redirect()->route('task.index');
        }
        return abort(401);
    }
}
