<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Contracts;

use BrianFaust\Picible\Models\Picture;

interface ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = []);
}
