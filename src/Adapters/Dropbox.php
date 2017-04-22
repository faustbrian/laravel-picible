<?php


declare(strict_types=1);

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
