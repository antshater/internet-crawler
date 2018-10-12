<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.10.2018
 * Time: 22:04
 */

namespace Tests\Unit;

use App\Jobs\DownloadJob;
use App\Task;
use Tests\TestCase;

class TasksCommandTest extends TestCase {
    public function testNewValidateUrl() {
        $this->artisan('tasks:new')
            ->expectsQuestion('Enter file url', 'invalid url')
            ->expectsQuestion('File format invalid, press enter to abort', 'invalid url')
            ->expectsQuestion('File format invalid, press enter to abort', null)
            ->assertExitCode(0);
    }

    public function testNewCreatesJob() {
        $this->expectsJobs(DownloadJob::class);
        $this->artisan('tasks:new')
            ->expectsQuestion('Enter file url', 'http://example.com/file.csv')
            ->assertExitCode(0);
    }

    public function testList() {

        /** @var $tasks Task[] */
        $tasks[] = factory(Task::class)->create([
            'status' => 'completed',
            'result_url' => 'http://asas.ru'
        ]);
        $tasks[] = factory(Task::class)->create([
            'status' => 'error',
            'error' => 'Failed',
        ]);
        $this->artisan('tasks:list')
            ->assertExitCode(0)
        ;
    }
}
