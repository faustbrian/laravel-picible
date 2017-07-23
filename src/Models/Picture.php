<?php

/*
 * This file is part of Laravel Picible.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Picible\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Picture extends Model
{
    protected $table = 'picible_picture';

    protected $fillable = [
        'picible_id',
        'picible_type',
        'slot',
        'width',
        'height',
        'mime_type',
        'extension',
        'orientation',
    ];

    public function picible()
    {
        return $this->morphTo();
    }

    public function scopeForPicible(Builder $query, $type, $id)
    {
        return $query->where('picible_type', $type)
                     ->where('picible_id', $id);
    }

    public function scopeInSlot(Builder $query, $slot)
    {
        return $query->whereIn('slot', (array) $slot);
    }

    public function scopeNotInSlot(Builder $query, $slot)
    {
        return $query->whereNotIn('slot', (array) $slot);
    }

    public function scopeWithoutSlot(Builder $query)
    {
        return $query->whereNull('slot');
    }

    public function scopeUnattached(Builder $query)
    {
        return $query->whereNull('picible_id')
                        ->whereNull('picible_type');
    }

    public function scopeAttached(Builder $query)
    {
        return $query->whereNotNull('picible_id')
                     ->whereNotNull('picible_type');
    }

    public function scopeHighestRes(Builder $query)
    {
        return $query->orderByRaw('(width * height) DESC');
    }

    public function scopeRandom(Builder $query)
    {
        return $query->orderBy('RAND()');
    }

    public function scopeInIntegerSlot(Builder $query)
    {
        return $query->whereRaw(
            sprintf('%s.slot REGEXP \'^[[:digit:]]+$\'', $query->getQuery()->from)
        );
    }

    public function scopeInNamedSlot(Builder $query, $slot)
    {
        return $query->where('slot', '=', $slot);
    }

    public function scopeOnlyPortrait(Builder $query)
    {
        return $query->where('orientation', '=', 'portrait');
    }

    public function scopeOnlyLandscape(Builder $query)
    {
        return $query->where('orientation', '=', 'landscape');
    }

    public function scopeWithMinimumWidth(Builder $query, $width)
    {
        return $query->where('width', '>=', $width);
    }

    public function scopeWithMinimumHeight(Builder $query, $height)
    {
        return $query->where('height', '>=', $height);
    }
}
