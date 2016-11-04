<?php

namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Orientate implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->orientate();
    }
}
