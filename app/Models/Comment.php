<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'post_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer'
    ];

    public function scopeByPost($query , $post_id)
    {
        return $query->where('post_id',$post_id);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
