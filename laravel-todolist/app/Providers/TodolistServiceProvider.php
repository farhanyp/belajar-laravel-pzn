<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use TodolistService;
use TodolistServiceImpl;

class TodolistServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        TodolistService::class => TodolistServiceImpl::class
    ];

    public function provides(): array
    {
        return [TodolistService::class];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
