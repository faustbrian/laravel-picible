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

use Intervention\Image\Image;

/**
 * Interface FilterInterface.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface FilterInterface
{
    /**
     * @param Image $image
     *
     * @return mixed
     */
    public function applyFilter(Image $image);
}
