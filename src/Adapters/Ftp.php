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
 * Class Ftp.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Ftp extends AbstractAdapter implements ShareableInterface
{
    /**
     * @param Picture $picture
     * @param array   $filters
     */
    public function getShareableLink(Picture $picture, array $filters = [])
    {
        //
    }
}
