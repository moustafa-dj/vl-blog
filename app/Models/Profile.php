<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'nb_following',
        'nb_followers',
        'social_links'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'nb_following' => 'integer',
        'nb_followers' => 'integer',
        'social_links' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
