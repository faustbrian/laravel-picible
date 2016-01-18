<?php

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
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
