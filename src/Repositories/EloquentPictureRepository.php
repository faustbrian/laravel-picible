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

namespace BrianFaust\Picible\Repositories;

use BrianFaust\Picible\Contracts\Picible;
use BrianFaust\Picible\Contracts\PictureRepository;
use BrianFaust\Picible\Models\Picture;

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
