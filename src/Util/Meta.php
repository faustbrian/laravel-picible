<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Util;

use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Meta.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class Meta
{
    /**
     * @var
     */
    protected $image;

    /**
     * Meta constructor.
     *
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->image = Image::make($file->getRealPath());
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->image->width();
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->image->height();
    }

    /**
     * @return string
     */
    public function getOrientation()
    {
        return ($this->getWidth() > $this->getHeight()) ? 'landscape' : 'portrait';
    }
}
