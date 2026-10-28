<?php
namespace App\Models;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role_id',
        'institute_id',
        'student_roll_no',
        'profile_image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class, 'institute_id');
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
        )->withPivot('class_id');
    }

    public function createdQuizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'created_by');
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }
    
public function permissions(): BelongsToMany
{
    return $this->belongsToMany(Permission::class, 'permission_user')
        ->withPivot('allowed')
        ->withTimestamps();
}

public function hasPermission(string $permissionName): bool
{
    if ($this->role?->role_name === 'system_admin') {
        return true;
    }

    $permission = Permission::where('name', $permissionName)->first();

    if (!$permission) {
        return false;
    }

    $individualPermission = $this->permissions()
        ->where('permissions.id', $permission->id)
        ->first();

    if ($individualPermission) {
        return (bool) $individualPermission->pivot->allowed;
    }

    return $this->role()
        ->whereHas('permissions', function ($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })
        ->exists();
}

}
