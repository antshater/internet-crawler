<?php

namespace Tests\Feature;

use App\Jobs\DownloadJob;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TasksStoreTest extends TestCase {

    use WithoutMiddleware;

    /**
     * @testWith
     * ["''"]
     * ["'not valid url'"]
     * @param $url
     */
    public function testValidation($url) {
        $this
            ->post('/', [
                'url' => $url,
            ])
            ->assertSessionHasErrors(['url'])
        ;
    }

    public function testSuccess() {
        $this->expectsJobs(DownloadJob::class);

        $this
            ->post('/', [
                'url' => 'http://example.com/file.csv',
            ])
            ->assertRedirect('/');
    }
}
