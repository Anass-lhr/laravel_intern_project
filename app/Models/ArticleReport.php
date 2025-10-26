<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleReport extends Model
{
    protected $fillable = [
        'article_id',
        'reporter_id',
        'reason_category',
        'reason_details',
        'status',
        'priority'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}