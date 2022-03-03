<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Contracts\FileManagerInterface;
use App\Services\S3FileManagerService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            FileManagerInterface::class,
            function () {
                return new S3FileManagerService();
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'post' => 'App\Models\Post',
        ]);
    }
}
