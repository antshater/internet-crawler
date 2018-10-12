<?php

namespace App\Jobs;

use App\Services\FileDownloadService;
use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;

class DownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Task
     */
    public $task;

    /**
     * Create a new job instance.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->task = new Task([
            'url'    => $url,
            'status' => Task::STATUS_PENDING,
        ]);

        $this->task->save();
    }

    /**
     * Execute the job.
     *
     * @param FileDownloadService $fileDownloadService
     * @return void
     */
    public function handle(FileDownloadService $fileDownloadService)
    {
        $this->task->status = Task::STATUS_DOWNLOADING;
        $this->task->save();

        try {
            $fileContent = $fileDownloadService->download($this->task->url);
        } catch (\ErrorException $e) {
            $this->task->status = Task::STATUS_ERROR;
            $this->task->error = $e->getMessage();
            $this->task->save();
            return;
        }

        $ext = array_get(pathinfo($this->task->url), 'extension');
        $targetFileName = md5($fileContent) . '.' . $ext;
        Storage::put($targetFileName, $fileContent);

        $this->task->result_url = $targetFileName;
        $this->task->status = Task::STATUS_COMPLETE;
        $this->task->save();
    }
}
