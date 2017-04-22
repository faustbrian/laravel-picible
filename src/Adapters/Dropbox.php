<?php



declare(strict_types=1);



namespace BrianFaust\Picible\Adapters;

use BrianFaust\Flysystem\Dropbox\DropboxAdapter;
use BrianFaust\Flysystem\Filesystem;
use BrianFaust\Picible\Contracts\ShareableInterface;
use BrianFaust\Picible\Models\Picture;
use Dropbox\Client;

class Dropbox extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();
        $client = new Client($config['token'], $config['app']);
        $adapter = new DropboxAdapter($client);
        $filesystem = new Filesystem($adapter);

        $path = $this->buildFileName($picture, $filters);

        return $filesystem->getAdapter()
                          ->getClient()
                          ->createShareableLink($path);
    }
}
