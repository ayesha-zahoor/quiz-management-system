<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    protected $fillable = [
        'institute_id',
        'name',
        'code',
    ];
    

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'class_teacher',
            'subject_id',
            'class_id'
        )->withPivot('teacher_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'class_teacher',
            'subject_id',
            'teacher_id'
        )->withPivot('class_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}