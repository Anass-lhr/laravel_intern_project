<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodcastsCommentReport extends Model
{
    use HasFactory;

    protected $table = 'podcasts_comments_reports';

    protected $fillable = [
        'user_id',
        'comment_id',
        'reply_id',
        'reason_category',
        'reason_details',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(PodcastComment::class, 'comment_id');
    }

    public function reply()
    {
        return $this->belongsTo(PodcastCommentReply::class, 'reply_id');
    }
}