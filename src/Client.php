<?php

namespace LaraDns;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use LaraDns\Events\SiteUpdated;
use LaraDns\Exceptions\ConfigurationMissingException;

class Client
{
    /**
     * The HTTP client being used for update requests.
     *
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * The unique site identifier for this site.
     *
     * @var string $siteId
     */
    private $siteId;

    /**
     * Store our last exception.
     *
     * @var \Exception $lastException
     */
    private $lastException;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->http = new GuzzleClient([
            'base_uri' => 'https://laradns.com/',
            'headers' => [
                "Content-Type"  => "application/json",
            ],
        ]);

        $this->siteId = env('LARADNS_ID',false);
    }

    /**
     * Syncronise this site up to LaraDNS.
     *
     * @return mixed
     * @throws \LaraDns\Exceptions\ConfigurationMissingException
     */
    public function sync()
    {
        if ($this->configurationMissing())
        {
            throw new ConfigurationMissingException('Configuration not found.');
        }

        try {
            $response = $this->performUpdate();
        } catch (Exception $exception) {
           $this->lastException = $exception;
           return false;
        }

        if ($response->updated)
        {
            event(new SiteUpdated($response->data->content));
        }

        return $response;
    }

    /**
     * Expose the last exception.
     *
     * @return Exception
     */
    public function getLastException()
    {
        return $this->lastException;
    }

    /**
     * Determine if we have a valid configuration.
     *
     * @return bool
     */
    private function configurationMissing()
    {
        return $this->siteId == false;
    }

    /**
     * Perform the GET request to make an update.
     *
     * @return string
     */
    private function performUpdate()
    {
        $response = $this->http->request('GET','update',[
            'query' => [
                'site' => env('LARADNS_ID')
            ],
        ]);

        return json_decode((string) $response->getBody());
    }
}