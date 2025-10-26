<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PodcastComment extends Model
{
    protected $fillable = ['user_id', 'video_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(PodcastCommentReply::class, 'comment_id');
    }
}