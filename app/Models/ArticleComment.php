<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ArticleComment extends Model
{
    use SoftDeletes;

    protected $fillable = ['article_id', 'user_id', 'content', 'reported', 'parent_id'];
    protected $casts = [
    'reported' => 'boolean',
    ];
    protected $dates = ['deleted_at'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ArticleCommentReply::class, 'comment_id')->withTrashed();
    }

    public function parent()
    {
        return $this->belongsTo(ArticleComment::class, 'parent_id');
    }
}