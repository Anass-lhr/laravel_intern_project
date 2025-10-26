<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_answered',
        'answered_by',
        'answered_at',
        'answer_content',
        'answer_images',
        'answer_videos',
        'is_public',
        'status'
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'is_answered' => 'boolean',
        'is_public' => 'boolean',
        'answer_images' => 'array',
        'answer_videos' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answeredBy()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }

    // Scopes
    public function scopeAnswered($query)
    {
        return $query->where('is_answered', true);
    }

    public function scopeUnanswered($query)
    {
        return $query->where('is_answered', false);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Mutators & Accessors
    public function getAnswerImagesUrlsAttribute()
    {
        if (!$this->answer_images) {
            return [];
        }
        
        return array_map(function($image) {
            return asset('storage/questions/images/' . $image);
        }, $this->answer_images);
    }

    public function getAnswerVideosUrlsAttribute()
    {
        if (!$this->answer_videos) {
            return [];
        }
        
        return array_map(function($video) {
            return asset('storage/questions/videos/' . $video);
        }, $this->answer_videos);
    }

    public function hasAnswer()
    {
        return $this->is_answered && !empty($this->answer_content);
    }
}