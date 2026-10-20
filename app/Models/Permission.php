<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Permission extends Model
{
    protected $fillable = [
      'name',
      'module',
      'description'
    ];
    public function roles():BelongsToMany{
        return $this->BelongsToMany(Role::class);
    }
}
