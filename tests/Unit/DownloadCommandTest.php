<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.10.2018
 * Time: 22:04
 */

namespace Tests\Unit;

use App\Jobs\DownloadJob;
use Tests\TestCase;

class DownloadCommandTest extends TestCase {
    public function testValidateUrl() {
        $this->artisan('app:download-file')
            ->expectsQuestion('Enter file url', 'invalid url')
            ->expectsQuestion('File format invalid, press enter to abort', 'invalid url')
            ->expectsQuestion('File format invalid, press enter to abort', null)
            ->assertExitCode(0);
    }

    public function testCreatesJob() {
        $this->expectsJobs(DownloadJob::class);
        $this->artisan('app:download-file')
            ->expectsQuestion('Enter file url', 'http://example.com/file.csv')
            ->assertExitCode(0);
    }
}
