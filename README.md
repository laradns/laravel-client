# LaraDNS - Client

This is the client for users of [LaraDNS](https://laradns.com) that exposes a `php artisan dns:sync` console command which updates the IP address of a particular Cloudflare DNS record with that of the originating request.

## Installation
As simple as it should be:

### Require it
```
composer require laradns/laravel-client
```
### Configure it
Add your unique ID obtained after adding your site via the [LaraDNS](https://laradns.com) interface:

```php
// .env

LARADNS_ID=AJBUEo3UcmZ0JDPgSCGxwIRrj5TyAU
```
### Run it
Schedule the command to execute as often, or as little, as you wish. As it's a console command, you can even include it in your deploy script to ensure your DNS is always up-to-date.
```php
// App/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    $schedule->command('dns:sync')->everyFiveMinutes();
}
```
## Events
You may wish to perform your own actions on an IP update. To facilitate this, the client fires an `LaraDns\Events\SiteUpdated` event each time an IP address changes, with the address as the payload.

Register a listener:
```php
// App/Providers/EventServiceProvider.php

protected $listen = [
    \LaraDns\Events\SiteUpdated::class => [
        \App\Listeners\SiteIpUpdated::class,
   ],
];

```
Handle the event:
```php
// App/Listeners/SiteIpUpdated.php

<?php

namespace App\Listeners;

class SiteIpUpdated
{
    public function __construct()
    {
        //
    }
    public function handle(\LaraDns\Events\SiteUpdated $event)
    {
        // $event->newIpAddress;
    }
}
```

## Help and Contact
Please feel free to contact hello@laradns.com for any assistance and troubleshooting. 
