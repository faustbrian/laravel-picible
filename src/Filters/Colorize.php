<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Picible\Filters;

use Artisanry\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Colorize implements FilterInterface
{
    public function __construct($config)
    {
        $this->red = $config['red'];
        $this->green = $config['green'];
        $this->blue = $config['blue'];
    }

    public function applyFilter(Image $image)
    {
        return $image->colorize($this->red, $this->green, $this->blue);
    }
}
