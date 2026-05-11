<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'series_id',
        'action',
        'description',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    const ACTION_ADDED = 'added';

    const ACTION_EDITED = 'edited';

    const ACTION_DELETED = 'deleted';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class)->withTrashed();
    }

    public function getActionIconAttribute(): string
    {
        return match ($this->action) {
            self::ACTION_ADDED => 'add',
            self::ACTION_EDITED => 'edit',
            self::ACTION_DELETED => 'delete_outline',
            default => 'info',
        };
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            self::ACTION_ADDED => 'Added to Collection',
            self::ACTION_EDITED => 'Edited Entry',
            self::ACTION_DELETED => 'Entry Removed',
            default => 'Activity',
        };
    }

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            self::ACTION_DELETED => 'text-error border-error',
            default => 'text-primary border-primary',
        };
    }
}
