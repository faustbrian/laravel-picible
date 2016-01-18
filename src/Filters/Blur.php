<?php

namespace DraperStudio\Picible\Filters;

use DraperStudio\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Blur implements FilterInterface
{
    private $amount;

    public function __construct($config)
    {
        $this->amount = $config['amount'];
    }

    public function applyFilter(Image $image)
    {
        return $image->blur($this->amount);
    }
}
