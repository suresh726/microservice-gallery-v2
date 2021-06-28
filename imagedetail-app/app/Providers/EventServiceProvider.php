<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Jobs\ImageEntryCreated;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \App::bindMethod(ImageEntryCreated::class, '@handle', fn($job) => $job->handle());

    }
}
