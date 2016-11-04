<?php

namespace BrianFaust\Picible\Adapters;

use BrianFaust\Picible\Contracts\ShareableInterface;
use BrianFaust\Picible\Models\Picture;

class GridFs extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = [])
    {
    }
}
