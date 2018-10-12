<?php

namespace Tests\Feature;

use App\Jobs\DownloadJob;
use App\Task;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Collection;
use Storage;
use Tests\TestCase;

class ApiTasksTest extends TestCase {

    use WithoutMiddleware;

    /**
     * @testWith
     * ["''"]
     * ["'not valid url'"]
     * @param $url
     */
    public function testValidation($url) {
        $this
            ->postJson('/api/tasks', [
                'url' => $url,
            ])
            ->assertJsonValidationErrors(['url']);
    }

    public function testSuccess() {
        $this->expectsJobs(DownloadJob::class);

        $this
            ->postJson('/api/tasks', [
                'url' => 'http://example.com/file.csv',
            ])
            ->assertSuccessful()
            ->assertJson([
                'data' => true,
            ]);
    }

    public function testIndex() {
        /** @var $tasks Collection */
        $tasks = factory(Task::class, 2)->create();

        $this->getJson(route('api.tasks.index'))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    [
                        'id' => $tasks->get(1)->id,
                        'status' => $tasks->get(1)->status,
                        'error' => $tasks->get(1)->error,
                        'url' => $tasks->get(1)->url,
                        'result_url' => Storage::url($tasks->get(1)->result_url)
                    ],
                    [
                        'id' => $tasks->get(0)->id,
                        'status' => $tasks->get(0)->status,
                        'error' => $tasks->get(0)->error,
                        'url' => $tasks->get(0)->url,
                        'result_url' => Storage::url($tasks->get(0)->result_url)
                    ],
                ],
            ]);
    }
}
