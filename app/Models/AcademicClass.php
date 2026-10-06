<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Institute;
use App\Models\User;
use App\Models\Quiz;


class AcademicClass extends Model
{
    protected $table = 'classes';

    protected $fillable = ['institute_id', 'class_name', 'group'];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_student', 'class_id', 'user_id');
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class_teacher', 'class_id', 'teacher_id')
            ->withPivot('subject_name');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'class_id');
    }
}
