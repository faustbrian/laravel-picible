<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Picible\Traits;

/**
 * Class PicibleTrait.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
trait PicibleTrait
{
    /**
     * @return mixed
     */
    public function pictures()
    {
        return $this->morphMany('DraperStudio\Picible\Models\Picture', 'picible');
    }
}
