<?php

namespace App\Console\Commands;

use App\Jobs\DownloadJob;
use Illuminate\Console\Command;
use Validator;

class DownloadFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-file';

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
        $url = $this->ask('Enter file url');
        $validator = $this->validate($url);
        while ($validator->errors()->isNotEmpty()) {
            $url = $this->ask('File format invalid, press enter to abort');
            if ($url === null) {
                break;
            }
            $validator = $this->validate($url);
        };

        if ($validator->errors()->isNotEmpty() || $url === null) {
            $this->info('Bye!');
            return;
        }

        $job = new DownloadJob($url);
        dispatch($job);
        $this->info("Download task id: {$job->task->id}, Bye!");
    }

    private function validate($url): \Illuminate\Validation\Validator {
        return Validator::make(['url' => $url], ['url' => 'url']);
    }
}
