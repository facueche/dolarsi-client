<?php

namespace DigitalRevolution\DolarSi\Providers;

use DigitalRevolution\DolarSi\Http\DolarSiService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DolarSiServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(DolarSiService::class, function () {
            $client = new Client([
                'base_uri' => 'https://www.dolarsi.com/api/',
            ]);

            return new DolarSiService($client);
        });
    }

    public function provides()
    {
        return [
            DolarSiService::class,
        ];
    }
}
