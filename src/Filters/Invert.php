<?php

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Invert implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->invert();
    }
}
