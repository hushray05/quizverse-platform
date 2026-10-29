<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'xp',
        'level',
        'streak',
        'coins',
        'avatar',
        'bio',
        'is_banned',
        'last_active_at',
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
            'is_banned' => 'boolean',
            'last_active_at' => 'datetime',
        ];
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function staffRecord(): HasOne
    {
        return $this->hasOne(StaffMember::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCreator(): bool
    {
        return in_array($this->role, ['creator', 'admin']);
    }

    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    public function getRankTitleAttribute(): string
    {
        return match(true) {
            $this->level >= 25 => 'Cosmic Archon',
            $this->level >= 15 => 'Quantum Grandmaster',
            $this->level >= 10 => 'Neural Elite',
            $this->level >= 5 => 'Prodigy Strategist',
            default => 'Cadet Initiate',
        };
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }
            return asset('storage/' . $this->avatar);
        }
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=2563eb&color=fff&bold=true";
    }

    public function scopePlayers($query)
    {
        return $query->where('role', 'player');
    }

    public function scopeCreators($query)
    {
        return $query->where('role', 'creator');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}
