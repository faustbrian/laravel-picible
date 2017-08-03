<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Filters;

use Intervention\Image\Image;
use BrianFaust\Picible\Contracts\FilterInterface;

class Brighten implements FilterInterface
{
    private $level;

    public function __construct($config)
    {
        $this->level = $config['level'];
    }

    public function applyFilter(Image $image)
    {
        return $image->brightness($this->level);
    }
}
