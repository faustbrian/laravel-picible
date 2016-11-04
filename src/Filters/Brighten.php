<?php

namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Brighten implements FilterInterface
{
    private $level;

    public function __construct($config)
    {
        $this->level = $config['level'];
    }

    public function applyFilter(Image $image)
    {
        return $image->brightness($this->level);
    }
}
