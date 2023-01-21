<?php
namespace Renfordt\Larvatar;

use Illuminate\Support\ServiceProvider;
class LarvatarServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->make('Renfordt\Larvatar\Larvatar');
    }
}