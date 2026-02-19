<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->paginate();

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        // TÂCHE : trouvez pourquoi cette ligne échoue et corrigez le modèle Eloquent (Model)
        auth()->user()->tasks()->create([
            'name' => $request->name
        ]);

        return 'Success';
    }
}
