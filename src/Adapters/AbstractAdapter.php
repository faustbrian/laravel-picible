<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Adapters;

use DraperStudio\Picible\Contracts\Adapter;
use DraperStudio\Picible\Models\Picture;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\File as IlluminateFile;
use Intervention\Image\Image;
use League\Flysystem\Filesystem;

/**
 * Class AbstractAdapter.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
abstract class AbstractAdapter implements Adapter
{
    /**
     * @var FlysystemManager
     */
    protected $flysystem;

    /**
     * @var
     */
    protected $connection;

    /**
     * AbstractAdapter constructor.
     *
     * @param FlysystemManager $flysystem
     */
    public function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
    }

    /**
     * @param Image   $file
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
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

    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function has(Picture $picture, array $filters = [])
    {
        return $this->getConnection()->has(
            $this->buildFileName($picture, $filters)
        );
    }

    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function delete(Picture $picture, array $filters = [])
    {
        if ($this->has($picture, $filters)) {
            return $this->getConnection()->delete(
                $this->buildFileName($picture, $filters)
            );
        }
    }

    /**
     * @return mixed
     */
    public function loadFlysystemConfig()
    {
        $adapterKey = config('picible.default');
        $adapterKey = config('picible.adapters.'.$adapterKey.'.connection');

        return config('flysystem.connections.'.$adapterKey);
    }

    /**
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getConnection()
    {
        $connection = $this->connection;

        if (!$connection instanceof Filesystem) {
            $connection = get_class($connection);
            throw new InvalidArgumentException("Class [$connection] does not implement Filesystem.");
        }

        return $connection;
    }

    /**
     * @param $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $this->flysystem->connection($this->connection);
    }

    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return string
     */
    protected function buildFileName(Picture $picture, array $filters = [])
    {
        return sprintf('%s-%s.%s',
            $picture->getKey(),
            $this->buildHash($picture, $filters),
            $picture->extension
        );
    }

    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return string
     */
    protected function buildHash(Picture $picture, array $filters = [])
    {
        $state = [
            'id' => (string) $picture->getKey(),
            'filters' => $filters,
        ];

        $state = $this->recursiveKeySort($state);

        return md5(json_encode($state));
    }

    /**
     * @param array $array
     *
     * @return array
     */
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
