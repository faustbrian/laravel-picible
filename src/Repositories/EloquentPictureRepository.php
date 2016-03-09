<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Repositories;

use DraperStudio\Picible\Contracts\PictureRepository;
use DraperStudio\Picible\Contracts\Picible;
use DraperStudio\Picible\Models\Picture;

/**
 * Class EloquentPictureRepository.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class EloquentPictureRepository implements PictureRepository
{
    /**
     * @var Picture
     */
    protected $model;

    /**
     * EloquentPictureRepository constructor.
     *
     * @param Picture $model
     */
    public function __construct(Picture $model)
    {
        $this->model = $model;
    }

    /**
     * @param $attributes
     *
     * @return static
     */
    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $slot
     * @param Picible|null $picible
     *
     * @return mixed
     */
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
