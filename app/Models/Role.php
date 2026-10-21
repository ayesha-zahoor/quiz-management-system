<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Permission;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'role_name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class,'role_id');
    }
    public function permissions():BelongsToMany 
    {
        return $this->BelongsToMany(Permission::class);
    }
}
