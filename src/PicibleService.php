<?php

namespace BrianFaust\Picible;

use BrianFaust\Picible\Contracts\Adapter;
use BrianFaust\Picible\Contracts\FilterInterface;
use BrianFaust\Picible\Contracts\Picible;
use BrianFaust\Picible\Contracts\PictureRepository;
use BrianFaust\Picible\Models\Picture;
use BrianFaust\Picible\Util\Meta;
use Illuminate\Foundation\Application;
use Intervention\Image\ImageManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;

class PicibleService
{
    private $intervention;

    protected $app;

    protected $adapter;

    protected $pictures;

    private $file;

    private $model;

    private $attributes = [];

    private $filters = [];

    private $overwrite = false;

    public function __construct(PictureRepository $pictures, Application $app, Adapter $adapter, ImageManager $intervention)
    {
        $this->pictures = $pictures;
        $this->app = $app;
        $this->adapter = $adapter;
        $this->intervention = $intervention;
    }

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

    public function getById($id)
    {
        return $this->pictures->getById($id);
    }

    public function getBySlot($slot)
    {
        return $this->pictures->getBySlot($slot, $this->getModel());
    }

    public function getShareableLink(Picture $picture)
    {
        $filters = $this->getFilters();

        if (!$this->getAdapter()->has($picture, $filters)) {
            throw new InvalidArgumentException('File not found.');
        }

        return $this->getAdapter()->getShareableLink($picture, $filters);
    }

    public function delete(Picture $picture)
    {
        $this->getAdapter()->delete($picture, $this->getFilters());
        $picture->delete();
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id), $this->getFilters());
    }

    public function deleteBySlot($slot)
    {
        return $this->delete($this->getBySlot($slot, $this->getModel()), $this->getFilters());
    }

    public function withFile(File $file)
    {
        $this->file = $file;

        return $this;
    }

    public function withModel(Picible $model)
    {
        $this->model = $model;

        return $this;
    }

    public function withAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function withFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

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

    protected function saveFile(File $file, Picture $picture, array $filters)
    {
        $pictureFile = $this->runFilters($file, $picture, $filters);

        $this->getAdapter()->write($pictureFile, $picture, $filters);
    }

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

    protected function getAdapter()
    {
        return $this->adapter;
    }

    protected function getFile()
    {
        return $this->file;
    }

    protected function getModel()
    {
        return $this->model;
    }

    protected function getAttributes()
    {
        return $this->attributes;
    }

    protected function getFilters()
    {
        return $this->filters;
    }
}
