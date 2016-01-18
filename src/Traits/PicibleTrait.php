<?php

namespace DraperStudio\Picible\Traits;

trait PicibleTrait
{
    public function pictures()
    {
        return $this->morphMany('DraperStudio\Picible\Models\Picture', 'picible');
    }
}
