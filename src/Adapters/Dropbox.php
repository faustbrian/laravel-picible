<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Adapters;

use DraperStudio\Picible\Contracts\ShareableInterface;
use DraperStudio\Picible\Models\Picture;
use Dropbox\Client;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;

/**
 * Class Dropbox.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Dropbox extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     */
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
