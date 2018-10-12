<?php

namespace App\Console\Commands;

use App\Task;
use Illuminate\Console\Command;
use Storage;

class TasksListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = Task::sorted()->get()->map(function (Task $task) {
            return [
                $task->id,
                $task->status,
                $task->url,
                $task->error ?? $task->resultUrl(),
            ];
        })->toArray();

        $this->output->table([
            'Id',
            'Status',
            'Url',
            'Result',
        ], $data);
    }
}
