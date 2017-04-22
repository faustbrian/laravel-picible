<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Watermark implements FilterInterface
{
    public function __construct($config)
    {
        $this->watermarkPath = $config['watermarkPath'];
        $this->position = $config['position'];
        $this->coordinatesX = $config['coordinatesX'];
        $this->coordinatesY = $config['coordinatesY'];
    }

    public function applyFilter(Image $image)
    {
        return $image->insert(
            $this->watermarkPath, $this->position,
            $this->coordinatesX, $this->coordinatesY
        );
    }
}
