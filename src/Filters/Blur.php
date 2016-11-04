<?php

namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
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
