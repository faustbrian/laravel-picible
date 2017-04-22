<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Adapters;

use BrianFaust\Picible\Contracts\ShareableInterface;
use BrianFaust\Picible\Models\Picture;

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
