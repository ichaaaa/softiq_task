<?php

namespace App\Console\Commands;

use App\Services\DataExportHandlerFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportToRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export xml data to redis';

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
        $file = $this->argument('file');

        if(!Storage::disk('local')->exists('public/'.$file)){
            $this->error('Source file does not exist!');
            return;
        }

        $xml = Storage::disk('local')->get('public/'.$file);

        $data = simplexml_load_string($xml);

        $cookieExportHandler = DataExportHandlerFactory::make('cookies');
        $cookieExportHandler->prepareXMLObject($xml);
        $cookieExportHandler->exportDataToRedis();

        $subdomainsExportHandler = DataExportHandlerFactory::make('subdomains');
        $subdomainsExportHandler->prepareXMLObject($xml);
        $subdomainsExportHandler->exportDataToRedis();

        $this->info("Data exported successfully");
    }
}
