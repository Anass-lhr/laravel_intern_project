<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCommentReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'comment_id',
        'article_id',
        'comment_content',
        'comment_author',
        'reported_by',
        'reporter_id',
        'comment_type',
        'reason_category',
        'reason_details',
        'status',
        'priority',
        'action_taken',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
        'resolved_by',
        'resolved_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'resolved_at' => 'datetime'
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    // Dynamic relationship to get the actual comment based on type
    public function getCommentAttribute()
    {
        if ($this->comment_type === 'comment') {
            return ArticleComment::withTrashed()->find($this->comment_id);
        } else {
            return ArticleCommentReply::withTrashed()->find($this->comment_id);
        }
    }

    // Get the comment user (author of the reported comment)
    public function getCommentUserAttribute()
    {
        $comment = $this->comment;
        return $comment ? $comment->user : null;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeDismissed($query)
    {
        return $query->where('status', 'dismissed');
    }

    public function scopeReviewing($query)
    {
        return $query->where('status', 'reviewing');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeByCommentType($query, $type)
    {
        return $query->where('comment_type', $type);
    }

    public function scopeByReasonCategory($query, $category)
    {
        return $query->where('reason_category', $category);
    }

    // Helper methods
    public function markAsReviewing($reviewerId)
    {
        $this->update([
            'status' => 'reviewing',
            'reviewed_by' => $reviewerId,
            'reviewed_at' => now()
        ]);
        
        return $this;
    }

    public function resolve($resolverId, $actionTaken = null, $adminNotes = null)
    {
        $this->update([
            'status' => 'resolved',
            'resolved_by' => $resolverId,
            'resolved_at' => now(),
            'action_taken' => $actionTaken,
            'admin_notes' => $adminNotes
        ]);
        
        return $this;
    }

    public function dismiss($dismisserId, $adminNotes = null)
    {
        $this->update([
            'status' => 'dismissed',
            'resolved_by' => $dismisserId,
            'resolved_at' => now(),
            'admin_notes' => $adminNotes
        ]);
        
        return $this;
    }

    // Status check methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    public function isDismissed()
    {
        return $this->status === 'dismissed';
    }

    public function isReviewing()
    {
        return $this->status === 'reviewing';
    }

    // Get reason category label
    public function getReasonCategoryLabelAttribute()
    {
        $labels = [
            'inappropriate' => 'Contenu inapproprié',
            'spam' => 'Spam',
            'harassment' => 'Harcèlement',
            'hate_speech' => 'Discours de haine',
            'violence' => 'Violence',
            'other' => 'Autre'
        ];

        return $labels[$this->reason_category] ?? 'Non spécifié';
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'En attente',
            'reviewing' => 'En cours de révision',
            'resolved' => 'Résolu',
            'dismissed' => 'Rejeté'
        ];

        return $labels[$this->status] ?? 'Inconnu';
    }

    // Get priority label
    public function getPriorityLabelAttribute()
    {
        $labels = [
            'low' => 'Faible',
            'medium' => 'Moyen',
            'high' => 'Élevé'
        ];

        return $labels[$this->priority] ?? 'Moyen';
    }

    // Get comment type label
    public function getCommentTypeLabelAttribute()
    {
        $labels = [
            'comment' => 'Commentaire',
            'reply' => 'Réponse'
        ];

        return $labels[$this->comment_type] ?? 'Commentaire';
    }

    // Check if the reported comment still exists
    public function commentExists()
    {
        if ($this->comment_type === 'comment') {
            return ArticleComment::where('id', $this->comment_id)->exists();
        } else {
            return ArticleCommentReply::where('id', $this->comment_id)->exists();
        }
    }

    // Get formatted created at date
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // Get formatted resolved at date
    public function getFormattedResolvedAtAttribute()
    {
        return $this->resolved_at ? $this->resolved_at->format('d/m/Y H:i') : null;
    }
}