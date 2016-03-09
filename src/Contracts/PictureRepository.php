<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Contracts;

/**
 * Interface PictureRepository.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface PictureRepository
{
    /**
     * @param $attributes
     *
     * @return mixed
     */
    public function create($attributes);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $slot
     * @param Picible|null $picible
     *
     * @return mixed
     */
    public function getBySlot($slot, Picible $picible = null);
}
