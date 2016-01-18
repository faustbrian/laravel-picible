<?php

namespace DraperStudio\Picible\Adapters;

use DraperStudio\Picible\Contracts\ShareableInterface;
use DraperStudio\Picible\Models\Picture;

class ZipArchive extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = [])
    {
        //
    }
}
