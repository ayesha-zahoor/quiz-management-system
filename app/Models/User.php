<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\SchoolClass;
use App\Models\AcademicClass;
use App\Models\Institute;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'institute_id',
        'student_roll_no',
        'profile_image',
        'password',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class,'institute_id');
    }

    public function taughtClasses(): BelongsToMany
    {
        return $this->belongsToMany(AcademicClass::class, 'class_teacher', 'teacher_id', 'class_id')
            ->withPivot('subject_name');
    }

   public function studentClasses(): BelongsToMany
{
    return $this->belongsToMany(
        SchoolClass::class,
        'class_student',
        'user_id',
        'class_id'
    );
}

    public function createdQuizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'created_by');
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
//     public function classesAsStudent(): HasOne
// {
//     return $this->hasOne(
//         SchoolClass::class,
//         'class_student',
//         'user_id',
//     )->withPivot('class_id');
// }

// public function classesAsTeacher(): BelongsToMany
// {
//     return $this->belongsToMany(
//         SchoolClass::class,
//         'class_teacher',
//         'teacher_id',
//         'class_id'
//     )->withPivot('subject_name');
// }
public function teachingClasses(): BelongsToMany
{
    return $this->belongsToMany(
        SchoolClass::class,
        'class_teacher',
        'teacher_id',
        'class_id'
    )->withPivot('subject_id');
}
public function teachingSubjects(): BelongsToMany
{
    return $this->belongsToMany(
        Subject::class,
        'class_teacher',
        'teacher_id',
        'subject_id'
    );
}
}
