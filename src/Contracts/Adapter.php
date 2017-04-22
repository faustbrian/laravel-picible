<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Contracts;

use BrianFaust\Picible\Models\Picture;
use Intervention\Image\Image;

interface Adapter
{
    public function write(Image $file, Picture $picture, array $filters = []);

    public function has(Picture $picture, array $filters = []);

    public function delete(Picture $picture, array $filters = []);
}
