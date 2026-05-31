<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return view('exercises.tasks.index', [
            'tasks' => Task::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        Task::create([
            'title' => $request->title,
            'completed' => false,
        ]);

        return back()->with('success', 'Tarea agregada correctamente.');
    }

    public function toggle(Task $task)
    {
        $task->update(['completed' => ! $task->completed]);

        return back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back()->with('success', 'Tarea eliminada.');
    }
}
