<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'status',
        'badge_text',
        'cta_text',
        'target_url',
        'content',
        'impressions',
        'clicks',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'impressions' => 'integer',
            'clicks' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
