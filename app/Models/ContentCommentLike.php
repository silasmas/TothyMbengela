<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentCommentLike extends Model
{
    protected $fillable = [
        'content_comment_id',
        'user_id',
        'liker_fingerprint',
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(ContentComment::class, 'content_comment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
