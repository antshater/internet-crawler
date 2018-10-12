<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksStoreRequest;
use App\Http\Resources\TasksResource;
use App\Jobs\DownloadJob;
use App\Task;

class ApiTasksController extends Controller {

    public function store(TasksStoreRequest $request) {

        $this->dispatch(new DownloadJob($request->input('url')));

        return response()->json(['data' => true]);
    }

    public function index() {
        $tasks = Task::sorted()->get();

        return TasksResource::collection($tasks);
    }
}
