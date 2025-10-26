<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    protected $fillable = [
        'user_id',
        'blocked_by',
        'blocked_at',
    ];

    protected $dates = [
        'blocked_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blockedBy()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }
}