<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'route_name',
        'method',
        'url',
        'ip_address',
        'user_agent',
        'request_data',
        'response_data',
        'status_code',
        'description',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'created_at' => 'datetime',
    ];

    // Pas de updated_at pour les logs
    public $timestamps = false;
    
    protected $dates = ['created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Méthode pour créer un log rapidement
    public static function logAction(
        string $action,
        ?int $userId = null,
        ?string $description = null,
        array $additionalData = []
    ): void {
        $request = request();
        
        self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'route_name' => $request->route()?->getName(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => self::sanitizeRequestData($request->all()),
            'response_data' => $additionalData,
            'status_code' => null, // Sera mis à jour par le middleware
            'description' => $description,
        ]);
    }

    // Sanitiser les données sensibles
    private static function sanitizeRequestData(array $data): array
    {
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            '_token',
            'api_token',
        ];

        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[MASQUÉ]';
            }
        }

        return $data;
    }
}