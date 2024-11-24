<?php

namespace Renfordt\Larvatar;

use Illuminate\Support\ServiceProvider;

class LarvatarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->make('Renfordt\Larvatar\Larvatar');
    }
}
