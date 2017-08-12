<?php

namespace Liliom\Firebase;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make(ChannelManager::class)->extend('firebase', function() {
            return $this->app->make(FirebaseChannel::class);
        });
    }
}
