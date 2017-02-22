<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Adapters;

use BrianFaust\Flysystem\Filesystem;
use BrianFaust\Picible\Contracts\Adapter;
use BrianFaust\Picible\Models\Picture;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\File as IlluminateFile;
use Intervention\Image\Image;

abstract class AbstractAdapter implements Adapter
{
    protected $flysystem;

    protected $connection;

    public function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
    }

    public function write(Image $file, Picture $picture, array $filters = [])
    {
        $filename = $this->buildFileName($picture, $filters);
        $targetPath = 'files/'.$filename;
        $tempFile = storage_path($targetPath.'.jpg');

        $file->save($tempFile);

        $result = $this->getConnection()->write(
            $filename, IlluminateFile::get($tempFile)
        );

        unlink($tempFile);

        return $result;
    }

    public function has(Picture $picture, array $filters = [])
    {
        return $this->getConnection()->has(
            $this->buildFileName($picture, $filters)
        );
    }

    public function delete(Picture $picture, array $filters = [])
    {
        if ($this->has($picture, $filters)) {
            return $this->getConnection()->delete(
                $this->buildFileName($picture, $filters)
            );
        }
    }

    public function loadFlysystemConfig()
    {
        $adapterKey = config('picible.default');
        $adapterKey = config('picible.adapters.'.$adapterKey.'.connection');

        return config('flysystem.connections.'.$adapterKey);
    }

    public function getConnection()
    {
        $connection = $this->connection;

        if (!$connection instanceof Filesystem) {
            $connection = get_class($connection);
            throw new InvalidArgumentException("Class [$connection] does not implement Filesystem.");
        }

        return $connection;
    }

    public function setConnection($connection)
    {
        $this->connection = $this->flysystem->connection($this->connection);
    }

    protected function buildFileName(Picture $picture, array $filters = [])
    {
        return sprintf('%s-%s.%s',
            $picture->getKey(),
            $this->buildHash($picture, $filters),
            $picture->extension
        );
    }

    protected function buildHash(Picture $picture, array $filters = [])
    {
        $state = [
            'id'      => (string) $picture->getKey(),
            'filters' => $filters,
        ];

        $state = $this->recursiveKeySort($state);

        return md5(json_encode($state));
    }

    protected function recursiveKeySort(array $array)
    {
        ksort($array);

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->recursiveKeySort($value);
            }
        }

        return $array;
    }
}
