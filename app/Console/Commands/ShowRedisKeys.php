<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ShowRedisKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show_redis_keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all redis keys';

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
     * @return int
     */
    public function handle()
    {
        $this->info("All keys:");
        foreach(Redis::keys('*') as $key=>$value){
            $this->line($value);
        }

    }
}
