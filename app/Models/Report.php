<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reportable_type',
        'reportable_id',
        'reason_category',
        'reason_details',
        'status',
        'admin_comment',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a fait le signalement
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation polymorphe avec l'élément signalé
     */
    public function reportable()
    {
        return $this->morphTo();
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pour les signalements en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les signalements approuvés
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope pour les signalements rejetés
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope pour les signalements d'articles
     */
    public function scopeForArticles($query)
    {
        return $query->where('reportable_type', Article::class);
    }

    /**
     * Accesseur pour obtenir le nom de la catégorie de raison
     */
    public function getReasonCategoryNameAttribute()
    {
        $categories = [
            'inappropriate' => 'Contenu inapproprié',
            'spam' => 'Spam',
            'harassment' => 'Harcèlement',
            'hate_speech' => 'Discours haineux',
            'violence' => 'Violence',
            'misinformation' => 'Désinformation',
            'copyright' => 'Violation de droits d\'auteur',
            'other' => 'Autre'
        ];

        return $categories[$this->reason_category] ?? 'Inconnu';
    }

    /**
     * Accesseur pour obtenir le nom du statut
     */
    public function getStatusNameAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'approved' => 'Approuvé',
            'rejected' => 'Rejeté'
        ];

        return $statuses[$this->status] ?? 'Inconnu';
    }

    /**
     * Vérifie si le signalement est en attente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifie si le signalement est approuvé
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Vérifie si le signalement est rejeté
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Vérifie si le signalement a été traité
     */
    public function isProcessed()
    {
        return in_array($this->status, ['approved', 'rejected']);
    }
}