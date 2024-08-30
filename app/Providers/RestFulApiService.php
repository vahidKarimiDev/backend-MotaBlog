<?php

namespace App\Providers;

use App\RestApi\ApiResponseBuilder;
use Illuminate\Support\ServiceProvider;

class RestFulApiService extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind("apiResponse", function () {
            return new ApiResponseBuilder();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
