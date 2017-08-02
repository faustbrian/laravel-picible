<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Filters;

use Intervention\Image\Image;
use BrianFaust\Picible\Contracts\FilterInterface;

class Watermark implements FilterInterface
{
    public function __construct($config)
    {
        $this->watermarkPath = $config['watermarkPath'];
        $this->position = $config['position'];
        $this->coordinatesX = $config['coordinatesX'];
        $this->coordinatesY = $config['coordinatesY'];
    }

    public function applyFilter(Image $image)
    {
        return $image->insert(
            $this->watermarkPath, $this->position,
            $this->coordinatesX, $this->coordinatesY
        );
    }
}
