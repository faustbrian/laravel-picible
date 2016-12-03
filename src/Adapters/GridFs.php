<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BrianFaust\Picible\Adapters;

use BrianFaust\Picible\Contracts\ShareableInterface;
use BrianFaust\Picible\Models\Picture;

class GridFs extends AbstractAdapter implements ShareableInterface
{
    public function getShareableLink(Picture $picture, array $filters = [])
    {
    }
}
