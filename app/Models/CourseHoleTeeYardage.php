<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseHoleTeeYardage extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_hole_id',
        'course_tee_id',
        'yardage',
    ];

    protected $casts = [
        'yardage' => 'integer',
    ];

    public function hole(): BelongsTo
    {
        return $this->belongsTo(CourseHole::class, 'course_hole_id');
    }

    public function tee(): BelongsTo
    {
        return $this->belongsTo(CourseTee::class, 'course_tee_id');
    }
}