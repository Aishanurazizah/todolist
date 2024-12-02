<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'deadline' => 'nullable|date',
        ]);
    
        Task::create([
            'title' => $request->title,
            'deadline' => $request->deadline,
            'is_completed' => false,
        ]);
    
        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'is_completed' => 'boolean',
            'deadline' => 'nullable|date',
        ]);
    
        $task->update([
            'is_completed' => $request->has('is_completed'),
            'deadline' => $request->deadline,
        ]);
    
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
}
