<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodolistController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy($id){
    
        Todolist::where('id', $id)->delete();

        return redirect()->route('home')->with('message', 'Task deleted successfully');
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'task_name' => ['required', 'string', 'max:199'],
        ]);

        $task_name = $request->input("task_name");

        return redirect()->route('task.show', $task_name)->with([
            'task_name' => $task_name
        ]);
    }

    public function show($task_name)
    {
        $tasks = Todolist::where('task_name', 'like', '%' . $task_name . '%')
                                ->orderBy('status', 'desc')
                                ->paginate(10);
        return view('view')->with(['tasks' => $tasks]);
    }
}
