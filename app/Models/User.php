<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function getTotalChaptersAttribute(): int
    {
        return (int) $this->series()->sum('chapters_completed');
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->series()->whereNotNull('rating')->avg('rating') ?? 0, 1);
    }

    public function getLibrarianRankAttribute(): string
    {
        $count = $this->series()->count();
        return match (true) {
            $count >= 200 => 'Grand Librarian',
            $count >= 100 => 'Senior Archivist',
            $count >= 50  => 'Archivist',
            $count >= 20  => 'Apprentice',
            default       => 'Initiate',
        };
    }
}
