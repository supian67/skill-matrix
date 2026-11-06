<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'employee_no', 'name', 'department', 'position', 'email', 'status', 'join_date',
    ];

    protected function casts(): array
    {
        return ['join_date' => 'date'];
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}
