<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TasksStoreRequest;
use App\Jobs\DownloadJob;


class ApiTasksController extends Controller {

    public function store(TasksStoreRequest $request) {

        $this->dispatch(new DownloadJob($request->input('url')));

        return response()->json(['data' => true]);
    }
}
