<?php

namespace DraperStudio\Picible\Contracts;

use DraperStudio\Picible\Models\Picture;

interface ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = []);
}
