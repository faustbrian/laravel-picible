<?php

namespace DraperStudio\Picible\Adapters;

use DraperStudio\Picible\Contracts\ShareableInterface;
use DraperStudio\Picible\Models\Picture;

class Local extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();

        $paths = [public_path(), storage_path()];

        $path = str_replace($paths, null, $config['path']);

        $path = config('app.url').$path.'/'.$this->buildFileName($picture, $filters);

        return $path;
    }
}
