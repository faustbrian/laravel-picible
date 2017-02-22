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

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Util;

use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\File;

class Meta
{
    protected $image;

    public function __construct(File $file)
    {
        $this->image = Image::make($file->getRealPath());
    }

    public function getWidth()
    {
        return $this->image->width();
    }

    public function getHeight()
    {
        return $this->image->height();
    }

    public function getOrientation()
    {
        return ($this->getWidth() > $this->getHeight()) ? 'landscape' : 'portrait';
    }
}
