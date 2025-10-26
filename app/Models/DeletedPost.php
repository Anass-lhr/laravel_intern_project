<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'media_type',
        'media_url',
        'user_id',
        'deleted_at',
        'deleted_by',
    ];

    // Ajouter deleted_at à la propriété $dates
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}