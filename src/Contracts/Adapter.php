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

use DraperStudio\Picible\Models\Picture;
use Intervention\Image\Image;

/**
 * Interface Adapter.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface Adapter
{
    /**
     * @param Image   $file
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     */
    public function write(Image $file, Picture $picture, array $filters = []);

    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     */
    public function has(Picture $picture, array $filters = []);

    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     */
    public function delete(Picture $picture, array $filters = []);
}
