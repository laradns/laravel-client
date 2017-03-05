<?php

namespace LaraDns\Console\Commands;

use Illuminate\Console\Command;
use LaraDns\Client;

class DnsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dns:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronise server IP address with LaraDNS and Cloudflare';

    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new command instance.
     * @param \LaraDns\Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $response = $this->client->sync();

        if (!$response)
        {
            $exception = $this->client->getLastException()->getMessage();
            $this->error("Update unsuccessful. Exception [$exception] was thrown.");

            return;
        }

        $this->info($response->message);
    }
}
