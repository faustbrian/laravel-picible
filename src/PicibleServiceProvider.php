<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

class PicibleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../config/laravel-picible.php' => config_path('laravel-picible.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-picible.php', 'laravel-picible');

        $this->app->bind(Contracts\PictureRepository::class, Repositories\EloquentPictureRepository::class);

        $this->app->singleton(PicibleService::class, function (Application $app) {
            $service = new PicibleService(
                $app->make(Contracts\PictureRepository::class),
                $app,
                $this->setFilesystemAdapter($app),
                new ImageManager()
            );

            return $service;
        });
    }

    protected function setFilesystemAdapter($app)
    {
        $adapterKey = config('laravel-picible.default');
        $config = config('laravel-picible.adapters.'.$adapterKey);

        if (empty($config)) {
            throw new InvalidArgumentException("Unsupported adapter [$adapterKey]");
        }

        $adapter = $app->make($config['driver']);
        $adapter->setConnection($config['connection']);

        return $adapter;
    }
}
