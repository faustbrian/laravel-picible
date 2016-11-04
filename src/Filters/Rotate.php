<?php

namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Rotate implements FilterInterface
{
    public function __construct($config)
    {
        $this->angle = $config['angle'];
    }

    public function applyFilter(Image $image)
    {
        return $image->rotate($this->angle);
    }
}
