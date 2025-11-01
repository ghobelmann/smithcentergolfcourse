<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseTee extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'color',
        'rating',
        'slope',
        'total_yardage',
        'gender',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'slope' => 'integer',
        'total_yardage' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function yardages(): HasMany
    {
        return $this->hasMany(CourseHoleTeeYardage::class);
    }

    public function getFormattedName(): string
    {
        return $this->color ? "{$this->name} ({$this->color})" : $this->name;
    }
}