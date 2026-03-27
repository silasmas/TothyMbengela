<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentComment extends Model
{
    protected $fillable = [
        'content_id',
        'user_id',
        'author_name',
        'author_email',
        'body',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ContentCommentLike::class, 'content_comment_id');
    }
}
