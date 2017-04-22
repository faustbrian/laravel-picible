<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Colorize implements FilterInterface
{
    public function __construct($config)
    {
        $this->red = $config['red'];
        $this->green = $config['green'];
        $this->blue = $config['blue'];
    }

    public function applyFilter(Image $image)
    {
        return $image->colorize($this->red, $this->green, $this->blue);
    }
}
