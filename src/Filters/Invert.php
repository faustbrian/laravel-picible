<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Invert implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->invert();
    }
}
