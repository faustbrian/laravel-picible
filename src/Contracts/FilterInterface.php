<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Contracts;

use Intervention\Image\Image;

interface FilterInterface
{
    public function applyFilter(Image $image);
}
