<?php

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
