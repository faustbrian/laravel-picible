<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

/**
 * Class Invert.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Invert implements FilterInterface
{
    /**
     * @param Image $image
     *
     * @return Image
     */
    public function applyFilter(Image $image)
    {
        return $image->invert();
    }
}
