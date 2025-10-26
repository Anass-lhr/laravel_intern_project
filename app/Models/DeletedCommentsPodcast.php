<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedCommentsPodcast extends Model
{
    use HasFactory;

    protected $table = 'deleted_comments_podcast';

    protected $fillable = [
        'content',
        'video_id',
        'user_id',
        'parent_id',
        'deleted_at',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function parent()
    {
        return $this->belongsTo(PodcastComment::class, 'parent_id');
    }
}