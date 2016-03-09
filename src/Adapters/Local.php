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

/**
 * Class Local.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Local extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed|string
     */
    public function getShareableLink(Picture $picture, array $filters = [])
    {
        $config = $this->loadFlysystemConfig();

        $paths = [public_path(), storage_path()];

        $path = str_replace($paths, null, $config['path']);

        $path = config('app.url').$path.'/'.$this->buildFileName($picture, $filters);

        return $path;
    }
}
