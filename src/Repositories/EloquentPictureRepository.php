<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Picible\Repositories;

use Artisanry\Picible\Contracts\Picible;
use Artisanry\Picible\Contracts\PictureRepository;
use Artisanry\Picible\Models\Picture;

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
