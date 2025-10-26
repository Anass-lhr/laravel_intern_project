<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCommentReply extends Model
{
    use SoftDeletes;

    protected $fillable = ['comment_id', 'user_id', 'parent_reply_id', 'content','reported'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'reported' => 'boolean',
    ];

    public function comment()
    {
        return $this->belongsTo(ArticleComment::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentReply()
    {
        return $this->belongsTo(ArticleCommentReply::class, 'parent_reply_id');
    }

    public function replies()
    {
        return $this->hasMany(ArticleCommentReply::class, 'parent_reply_id')->withTrashed();
    }
}