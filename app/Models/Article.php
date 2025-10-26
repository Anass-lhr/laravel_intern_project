<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'image',
        'description',
        'auteur',
        'categorie',
        'corps',
        'created_by',
        'is_deleted',
        'deleted_by',
        'deleted_at',
        'status', 
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'is_deleted' => 'boolean',
        'categorie' => 'array',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who created the article.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who deleted the article.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get the reports for this article.
     */
    public function reports()
    {
        return $this->hasMany(ArticleReport::class);
    }

    /**
     * Get the comments for this article.
     */
    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }
}