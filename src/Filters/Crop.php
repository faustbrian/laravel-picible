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
 * Class Crop.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Crop implements FilterInterface
{
    /**
     * Crop constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->height = $config['height'];
        $this->width = $config['width'];
        $this->coordinatesX = $config['coordinatesX'];
        $this->coordinatesY = $config['coordinatesY'];
    }

    /**
     * @param Image $image
     *
     * @return Image
     */
    public function applyFilter(Image $image)
    {
        return $image->crop(
            $this->width,
            $this->height,
            $this->coordinatesX,
            $this->coordinatesY
        );
    }
}
