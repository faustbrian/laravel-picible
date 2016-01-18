<?php

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

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
