<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PodcastLike extends Model
{
    protected $fillable = ['user_id', 'video_id'];
    protected $table = 'podcast_likes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}