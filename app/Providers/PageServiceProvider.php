<?php

namespace App\Providers;

use App\Common\Page;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton("page",function(){
            return new Page(Request::capture());
        });
    }

}
