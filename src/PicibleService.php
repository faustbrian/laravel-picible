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

use DraperStudio\Picible\Contracts\Adapter;
use DraperStudio\Picible\Contracts\FilterInterface;
use DraperStudio\Picible\Contracts\Picible;
use DraperStudio\Picible\Contracts\PictureRepository;
use DraperStudio\Picible\Models\Picture;
use DraperStudio\Picible\Util\Meta;
use Illuminate\Foundation\Application;
use Intervention\Image\ImageManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class PicibleService.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class PicibleService
{
    /**
     * @var ImageManager
     */
    private $intervention;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * @var PictureRepository
     */
    protected $pictures;

    /**
     * @var
     */
    private $file;

    /**
     * @var
     */
    private $model;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var bool
     */
    private $overwrite = false;

    /**
     * PicibleService constructor.
     *
     * @param PictureRepository $pictures
     * @param Application       $app
     * @param Adapter           $adapter
     * @param ImageManager      $intervention
     */
    public function __construct(PictureRepository $pictures, Application $app, Adapter $adapter, ImageManager $intervention)
    {
        $this->pictures = $pictures;
        $this->app = $app;
        $this->adapter = $adapter;
        $this->intervention = $intervention;
    }

    /**
     * @param bool $overwrite
     *
     * @return mixed
     */
    public function commit($overwrite = false)
    {
        $file = $this->getFile();
        $model = $this->getModel();
        $attributes = $this->getAttributes();
        $filters = $this->getFilters();

        if (!empty($attributes['slot'])) {
            $record = $this->pictures->getBySlot($attributes['slot'], $model);

            if (!empty($record)) {
                if ($overwrite) {
                    $this->deleteById($record->id, $filters);
                } else {
                    $id = $record->picible_id;
                    $type = $record->picible_type;

                    throw new InvalidArgumentException("Slot [{$attributes['slot']}] is already in use for model [$type] with the id #[$id]");
                }
            }
        }

        $picture = $this->createPictureRecord($file, $attributes);

        // Believe it or not, picibles are optional!
        if ($model) {
            $model->pictures()->save($picture);
        }

        $this->saveFile($file, $picture, $filters);

        return $picture;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->pictures->getById($id);
    }

    /**
     * @param $slot
     *
     * @return mixed
     */
    public function getBySlot($slot)
    {
        return $this->pictures->getBySlot($slot, $this->getModel());
    }

    /**
     * @param Picture $picture
     *
     * @return mixed
     */
    public function getShareableLink(Picture $picture)
    {
        $filters = $this->getFilters();

        if (!$this->getAdapter()->has($picture, $filters)) {
            throw new InvalidArgumentException('File not found.');
        }

        return $this->getAdapter()->getShareableLink($picture, $filters);
    }

    /**
     * @param Picture $picture
     *
     * @throws \Exception
     */
    public function delete(Picture $picture)
    {
        $this->getAdapter()->delete($picture, $this->getFilters());
        $picture->delete();
    }

    /**
     * @param $id
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id), $this->getFilters());
    }

    /**
     * @param $slot
     */
    public function deleteBySlot($slot)
    {
        return $this->delete($this->getBySlot($slot, $this->getModel()), $this->getFilters());
    }

    /**
     * @param File $file
     *
     * @return $this
     */
    public function withFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @param Picible $model
     *
     * @return $this
     */
    public function withModel(Picible $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function withAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $filters
     *
     * @return $this
     */
    public function withFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param File  $picture
     * @param array $attributes
     *
     * @return mixed
     */
    protected function createPictureRecord(File $picture, array $attributes)
    {
        $meta = new Meta($picture, $this->intervention);

        $attributes = array_merge($attributes, [
            'width' => $meta->getWidth(),
            'height' => $meta->getHeight(),
            'orientation' => $meta->getOrientation(),
            'mime_type' => $picture->getMimeType(),
            'extension' => $picture->guessExtension(),
        ]);

        return $this->pictures->create($attributes);
    }

    /**
     * @param File    $file
     * @param Picture $picture
     * @param array   $filters
     */
    protected function saveFile(File $file, Picture $picture, array $filters)
    {
        $pictureFile = $this->runFilters($file, $picture, $filters);

        $this->getAdapter()->write($pictureFile, $picture, $filters);
    }

    /**
     * @param File    $file
     * @param Picture $picture
     * @param array   $filters
     *
     * @return Picture|\Intervention\Image\Image
     */
    protected function runFilters(File $file, Picture $picture, array $filters)
    {
        $availableFilters = config('picible.filters');

        // $picture = $this->intervention->open($file->getRealPath());
        $picture = $this->intervention->make($file->getRealPath());

        foreach ($filters as $key => $filter) {
            if (!array_key_exists($filter, $availableFilters)) {
                throw new InvalidArgumentException("Unsupported filter [$filter]");
            }

            $filter = $availableFilters[$filter];

            if (!isset($filter[0])) {
                $this->applyFilter($filter['driver'], $filter['config'], $picture);
            } else {
                foreach ($filter as $key => $value) {
                    $config = empty($value['config']) ?: $value['config'];

                    $this->applyFilter($value['driver'], $config, $picture);
                }
            }
        }

        return $picture;
    }

    /**
     * @param $driver
     * @param $config
     * @param $picture
     */
    protected function applyFilter($driver, $config, $picture)
    {
        $abstract = new $driver($config);

        if (!$abstract) {
            throw new InvalidArgumentException("Filter [$abstract] not resolvable.");
        }

        if (!$abstract instanceof FilterInterface) {
            $abstract = get_class($abstract);
            throw new InvalidArgumentException("Class [$abstract] does not implement FilterInterface.");
        }

        $abstract->applyFilter($picture);
    }

    /**
     * @return Adapter
     */
    protected function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return mixed
     */
    protected function getFile()
    {
        return $this->file;
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @return array
     */
    protected function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        return $this->filters;
    }
}
