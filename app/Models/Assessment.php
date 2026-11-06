<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    protected $fillable = [
        'employee_id',
        'skill_id',
        'assessed_level',
        'target_level',
        'assessed_at',
        'period_year',
        'period_quarter',
        'assessor',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assessed_at' => 'date',
            'period_year' => 'integer',
            'period_quarter' => 'integer',
            'assessed_level' => 'integer',
            'target_level' => 'integer',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function getGapAttribute(): int
    {
        return max(
            0,
            (int) $this->target_level - (int) $this->assessed_level
        );
    }

    public function getPeriodLabelAttribute(): string
    {
        if (!$this->period_year || !$this->period_quarter) {
            return '-';
        }

        return 'Q' . $this->period_quarter . ' - ' . $this->period_year;
    }
}