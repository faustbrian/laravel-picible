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
 * Class Watermark.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Watermark implements FilterInterface
{
    /**
     * Watermark constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->watermarkPath = $config['watermarkPath'];
        $this->position = $config['position'];
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
        return $image->insert(
            $this->watermarkPath, $this->position,
            $this->coordinatesX, $this->coordinatesY
        );
    }
}
