<?php

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Sharpen implements FilterInterface
{
    public function __construct($config)
    {
        $this->sharpen = $config['sharpen'];
    }

    public function applyFilter(Image $image)
    {
        return $image->sharpen($this->amount);
    }
}
