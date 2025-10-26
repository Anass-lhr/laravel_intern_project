<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_role_change',
        'was_admin_before',
        'admin_since',
        'is_active',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_role_change' => 'datetime',
        'admin_since' => 'datetime',
        'was_admin_before' => 'boolean',
        'is_active' => 'boolean',
    ];
        protected $hidden = [
        'password',
        'remember_token',
    ];

        public function affectation()
    {
        return $this->hasOne(Affectation::class);
    }
public function canManageModuleType($type)
{
    if (!$this->is_active && $this->role === 'admin') {
        return false;
    }

    $affectation = $this->affectation;

    if (!$affectation || empty($affectation->modules)) {
        return false;
    }

    $allowedTypes = is_array($affectation->modules)
        ? $affectation->modules
        : json_decode($affectation->modules, true);

    return is_array($allowedTypes) && in_array($type, $allowedTypes);
}

    public function isFormerAdmin(): bool
    {
        return $this->was_admin_before && $this->role === 'user';
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function deletedPosts()
    {
        return $this->hasMany(DeletedPost::class);
    }

    public function deletedComments()
    {
        return $this->hasMany(DeletedComment::class, 'deleted_by');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function isAdminOrSuperAdmin(): bool
{
    if ($this->role === 'superadmin') {
        return true;
    }
    
    if ($this->role === 'admin') {
        return $this->is_active;
    }
    
    return false;
}

    public function canManageForum()
    {
        if ($this->role === 'superadmin') {
            return true; 
        }

        if ($this->role === 'admin' && $this->is_active) {
            return $this->canManageModuleType('forum');
        }

        return false;
    }
    
}