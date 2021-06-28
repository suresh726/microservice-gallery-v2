<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Jobs\CategoryCreated;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \App::bindMethod(CategoryCreated::class, '@handle', fn($job) => $job->handle());
    }
}
