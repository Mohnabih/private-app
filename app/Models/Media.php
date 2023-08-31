<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media as BaseMedia;


class Media extends BaseMedia implements HasMedia
{
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }


    protected $hidden=[
        'model_type',
        'model_id',
        'collection_name',
        'name',
        'disk',
        'size',
        'manipulations',
        'custom_properties',
        'responsive_images',
        'order_column',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'url',
        'thumb',
        'icon',
        'formated_size'
    ];

    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($conversion = '')
    {
        $url = $this->getUrl();
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension, config('medialibrary.extensions_has_thumb'))) {
            return asset($this->getUrl($conversion));
        } else {
            return null;
        }
    }

    public function getUrlAttribute()
    {
        return $this->getFullUrl();
    }

    public function getThumbAttribute()
    {
        return $this->getFirstMediaUrl('thumb');
    }

    public function getIconAttribute()
    {
        return $this->getFirstMediaUrl('icon');
    }

    public function getFormatedSizeAttribute()
    {
        return formatedSize($this->size);
    }
}
