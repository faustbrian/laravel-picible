<?php

namespace DraperStudio\Picible\Repositories;

use DraperStudio\Picible\Contracts\PictureRepository;
use DraperStudio\Picible\Contracts\Picible;
use DraperStudio\Picible\Models\Picture;

class EloquentPictureRepository implements PictureRepository
{
    protected $model;

    public function __construct(Picture $model)
    {
        $this->model = $model;
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function getBySlot($slot, Picible $picible = null)
    {
        if ($picible) {
            $query = $this->model->forPicible(get_class($picible), $picible->getKey());
        } else {
            $query = $this->model->unattached();
        }

        return $query->inSlot($slot)->first();
    }
}
