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

namespace Artisanry\Picible\Contracts;

interface PictureRepository
{
    public function create($attributes);

    public function getById($id);

    public function getBySlot($slot, Picible $picible = null);
}
