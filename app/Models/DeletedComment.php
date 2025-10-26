<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'parent_id',
        'deleted_at',
        'deleted_by',
    ];

    // Ajouter deleted_at à la propriété $dates
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}