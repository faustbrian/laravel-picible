<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible;

use Illuminate\Foundation\Application;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

/**
 * Class ServiceProvider.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class ServiceProvider extends \DraperStudio\ServiceProvider\ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishMigrations();

        $this->publishConfig();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        parent::register();

        $this->mergeConfig();

        $this->app->bind(
            \DraperStudio\Picible\Contracts\PictureRepository::class,
            \DraperStudio\Picible\Repositories\EloquentPictureRepository::class
        );

        $this->app->singleton('DraperStudio\Picible\PicibleService', function (Application $app) {
            $service = new PicibleService(
                $app->make('DraperStudio\Picible\Contracts\PictureRepository'),
                $app,
                $this->setFilesystemAdapter($app),
                new ImageManager()
            );

            return $service;
        });
    }

    /**
     * @param $app
     *
     * @return mixed
     */
    protected function setFilesystemAdapter($app)
    {
        $adapterKey = config('picible.default');
        $config = config('picible.adapters.'.$adapterKey);

        if (empty($config)) {
            throw new InvalidArgumentException("Unsupported adapter [$adapterKey]");
        }

        $adapter = $app->make($config['driver']);
        $adapter->setConnection($config['connection']);

        return $adapter;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(parent::provides(), [
            \DraperStudio\Picible\PicibleService::class,
            \DraperStudio\Picible\Contracts\PictureRepository::class,
        ]);
    }
    /**
     * Get the default package name.
     *
     * @return string
     */
    public function getPackageName()
    {
        return 'picible';
    }
}
