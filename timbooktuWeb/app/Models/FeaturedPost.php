<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedPost extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'image_path',
        'audio_path',
    ];
}
