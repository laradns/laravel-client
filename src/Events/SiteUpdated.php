<?php
namespace LaraDns\Events;

class SiteUpdated
{
    /**
     * The new IP address that has been assigned to this site.
     *
     * @var string $newIpAddress
     */
    public $newIpAddress;

    public function __construct($newIpAddress)
    {
        $this->newIpAddress = $newIpAddress;
    }
}