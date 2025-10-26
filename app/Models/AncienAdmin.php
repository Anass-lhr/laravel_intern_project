<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AncienAdmin extends Model
{
    protected $table = 'anciens_admins'; // Spécifie explicitement le nom de la table avec underscore et pluriel
    
    protected $fillable = ['name', 'email', 'modules', 'start_date', 'end_date'];
    
    protected $casts = [
        'modules' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}