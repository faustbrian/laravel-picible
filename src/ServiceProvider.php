<?php

namespace DraperStudio\Picible;

use Illuminate\Foundation\Application;
use DraperStudio\ServiceProvider\ServiceProvider as BaseProvider;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

class ServiceProvider extends BaseProvider
{
    protected $packageName = 'picible';

    public function boot()
    {
        $this->setup(__DIR__)
             ->publishMigrations()
             ->publishConfig()
             ->mergeConfig('picible');
    }

    public function register()
    {
        $this->app->bind(
            'DraperStudio\Picible\Contracts\PictureRepository',
            'DraperStudio\Picible\Repositories\EloquentPictureRepository'
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

    //
    // public function provides()
    // {
    //     return [
    //         'DraperStudio\Picible\PicibleService',
    //         'DraperStudio\Picible\PictureRepository',
    //     ];
    // }
}
