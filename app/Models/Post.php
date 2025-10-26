<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'media_type', 'media_url', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(PostVote::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function getVoteScoreAttribute()
    {
        return $this->votes()->sum('is_upvote') - $this->votes()->where('is_upvote', 0)->count();
    }
}