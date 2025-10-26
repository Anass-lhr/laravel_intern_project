<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'modules'];

    // Spécifier que le champ module est un tableau JSON
    protected $casts = [
        'modules' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}