<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Contracts;

use BrianFaust\Picible\Models\Picture;

interface ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = []);
}
