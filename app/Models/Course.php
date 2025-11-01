<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'website',
        'hole_count',
        'par',
        'yardage',
        'active',
    ];

    protected $casts = [
        'par' => 'integer',
        'yardage' => 'integer',
        'hole_count' => 'integer',
        'active' => 'boolean',
    ];

    public function holes(): HasMany
    {
        return $this->hasMany(CourseHole::class)->orderBy('hole_number');
    }

    public function tees(): HasMany
    {
        return $this->hasMany(CourseTee::class);
    }

    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class);
    }

    // Helper methods
    public function getTotalPar(): int
    {
        return $this->holes()->sum('par');
    }

    public function getYardageForTee(CourseTee $tee): int
    {
        return $tee->total_yardage ?? $this->holes()
            ->join('course_hole_tee_yardages', 'course_holes.id', '=', 'course_hole_tee_yardages.course_hole_id')
            ->where('course_hole_tee_yardages.course_tee_id', $tee->id)
            ->sum('course_hole_tee_yardages.yardage');
    }

    public function getDefaultTee(): ?CourseTee
    {
        return $this->tees()->first();
    }
}