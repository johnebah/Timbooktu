<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestPost extends Model
{
    protected $fillable = [
        'author_name',
        'author_email',
        'title',
        'body',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
}
