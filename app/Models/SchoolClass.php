<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Institute;
use App\Models\User;


class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'institute_id',
        'class_name',
        'group',
        'sort_order',
    ];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'class_student',
            'class_id',
            'user_id'
        );
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'class_teacher',
            'class_id',
            'teacher_id'
        );
    }
    
}