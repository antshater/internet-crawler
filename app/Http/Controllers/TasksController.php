<?php

namespace App\Http\Controllers;

use App\Http\Requests\TasksStoreRequest;
use App\Jobs\DownloadJob;
use App\Task;


class TasksController extends Controller {

    public function index() {
        $tasks = Task::sorted()->get();

        return view('tasks.index', compact('tasks'));
    }

    public function store(TasksStoreRequest $request) {

        $this->dispatch(new DownloadJob($request->input('url')));

        return redirect('/');
    }
}
