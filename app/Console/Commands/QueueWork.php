<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class QueueWork extends Command
{

    protected $signature = 'QueueWork';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'キューワーカの実行';

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
        Log::useDailyFiles(storage_path('logs/batch/queue_work/batch.log'), 7);
        Log::info($this->description. ':開始');

        $cmd = "php artisan queue:restart";
        shell_exec($cmd);

        $cmd = "php artisan queue:work --tries=1 --timeout=30";
        shell_exec($cmd);

        Log::info($this->description. ':終了');
    }
}