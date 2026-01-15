<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RichUsMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'attachment_path',
        'contacted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];
}
