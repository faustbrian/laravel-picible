<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Contracts;

use DraperStudio\Picible\Models\Picture;

/**
 * Interface ShareableInterface.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
interface ShareableInterface
{
    /**
     * @param Picture $picture
     * @param array   $filters
     *
     * @return mixed
     */
    public function getShareableLink(Picture $picture, array $filters = []);
}
