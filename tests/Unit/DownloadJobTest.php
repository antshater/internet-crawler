<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.10.2018
 * Time: 14:56
 */

namespace Tests\Unit;

use App\Jobs\DownloadJob;
use App\Services\FileDownloadService;
use App\Task;
use ErrorException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Storage;
use Tests\TestCase;

class DownloadJobTest extends TestCase {

    use DatabaseTransactions;

    public function testCreatesTask() {
        $job = new DownloadJob('http://example.com/file.csv1');
        $this->assertNotNull($job->task);
        $this->assertEquals('http://example.com/file.csv1', $job->task->url);
        $this->assertEquals(Task::STATUS_PENDING, $job->task->status);
    }

    public function testDownloadFile() {
        Storage::fake('public');
        $job = new DownloadJob('http://example.com/file.csv1');
        $fileDownloadService = $this->createMock(FileDownloadService::class);
        $fileDownloadService->method('download')->willReturn('file-content');
        $job->handle($fileDownloadService);
        $this->assertEquals(Task::STATUS_COMPLETE, $job->task->status);
        Storage::assertExists($job->task->result_url);
    }

    public function testDownloadError() {
        $job = new DownloadJob('http://example.com/file.csv1');
        $fileDownloadService = $this->createMock(FileDownloadService::class);
        $fileDownloadService->method('download')->willThrowException(new ErrorException('File unreachable'));
        $job->handle($fileDownloadService);
        $this->assertEquals(Task::STATUS_ERROR, $job->task->status);
        $this->assertEquals('File unreachable', $job->task->error);
    }
}
