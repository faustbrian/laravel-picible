<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Adapters;

use BrianFaust\Picible\Models\Picture;
use BrianFaust\Picible\Contracts\ShareableInterface;

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
