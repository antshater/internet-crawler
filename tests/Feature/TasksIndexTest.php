<?php

namespace Tests\Feature;

use App\Jobs\DownloadJob;
use App\Task;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TasksIndexTest extends TestCase {

    public function testIndexSuccess() {

        /** @var Task[] $tasks */
        $tasks = [];

        $tasks[] = factory(Task::class)->create([
            'status'     => Task::STATUS_PENDING,
            'result_url' => null,
        ]);

        $tasks[] = factory(Task::class)->create([
            'status' => Task::STATUS_COMPLETE,
        ]);

        $this->get('/')
            ->assertSuccessful()
            ->assertSee($tasks[0]->status)
            ->assertSee($tasks[1]->status)
            ->assertSee($tasks[1]->result_url)
            ->assertSee('download-link-' . $tasks[1]->id)
            ->assertDontSee('download-link-' . $tasks[0]->id)
            ->assertSee($tasks[0]->url)
            ->assertSee($tasks[1]->url);
    }

}
