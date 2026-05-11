<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'synopsis',
        'cover_image',
        'source_link',
        'format_origin',
        'induction_date',
        'chapters_completed',
        'chapters_total',
        'rating',
        'status',
        'type',
        'tags',
        'official_sources',
    ];

    protected $casts = [
        'induction_date' => 'date',
        'chapters_completed' => 'integer',
        'chapters_total' => 'integer',
        'rating' => 'decimal:1',
        'tags' => 'array',
        'official_sources' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function getProgressPercentageAttribute(): int
    {
        if (!$this->chapters_total || $this->chapters_total === 0) {
            return 0;
        }
        return (int) round(($this->chapters_completed / $this->chapters_total) * 100);
    }

    public function getFormattedChaptersAttribute(): string
    {
        $completed = $this->chapters_completed ?? 0;
        $total = $this->chapters_total ? $this->chapters_total : '?';
        return "Ch. {$completed} / {$total}";
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%");
        })->when($filters['type'] ?? null, function ($q, $type) {
            if (strtolower($type) !== 'all') {
                $q->where('type', strtoupper($type));
            }
        })->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        });
    }
}
