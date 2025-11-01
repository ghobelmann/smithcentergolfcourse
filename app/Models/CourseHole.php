<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseHole extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'hole_number',
        'par',
        'handicap',
        'name',
    ];

    protected $casts = [
        'hole_number' => 'integer',
        'par' => 'integer',
        'handicap' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function yardages(): HasMany
    {
        return $this->hasMany(CourseHoleTeeYardage::class);
    }

    public function getYardageForTee(CourseTee $tee): ?int
    {
        $yardage = $this->yardages()->where('course_tee_id', $tee->id)->first();
        return $yardage?->yardage;
    }
}