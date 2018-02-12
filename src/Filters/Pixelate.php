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

use BrianFaust\Picible\Contracts\FilterInterface;
use Intervention\Image\Image;

class Pixelate implements FilterInterface
{
    private $amount;

    public function __construct($config)
    {
        $this->amount = $config['amount'];
    }

    public function applyFilter(Image $image)
    {
        return $image->pixelate($this->amount);
    }
}
