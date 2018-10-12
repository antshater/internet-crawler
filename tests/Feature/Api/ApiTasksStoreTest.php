<?php

namespace Tests\Feature;

use App\Jobs\DownloadJob;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ApiTasksStoreTest extends TestCase {

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
            ])
        ;
    }
}
