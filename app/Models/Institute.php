<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Institute extends Model
{
    protected $fillable = ['name', 'license_key', 'license_expires_at', 'status','logo','email','Contact','address'];

    protected function casts(): array
    {
        return ['license_expires_at' => 'datetime'];
    }

    
    public function configuration(): HasOne
    {
        return $this->hasOne(InstituteConfiguration::class,'institute_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class,'institute_id');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(AcademicClass::class);
    }
}
