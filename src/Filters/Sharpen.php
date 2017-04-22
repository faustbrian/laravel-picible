<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Filters;

use BrianFaust\Picible\Contracts\FilterInterface;
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
