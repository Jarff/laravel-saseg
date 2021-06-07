<?php

namespace Rodsaseg\LaravelSaseg\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Gallery extends Model implements HasMedia
{
    
    protected $fillable = [
        'title',
        'slug',
        'status'
    ];

    public function scopeVisible($query){
        return $query->where('status', 'visible');
    }
}
