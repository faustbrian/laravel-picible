<?php

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
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
