<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
      
        'primary_color',
        'facebook_url',
        'youtube_url',
        'instagram_url',
        'linkedin_url',
        'email',
        'modified_by',
    ];

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}