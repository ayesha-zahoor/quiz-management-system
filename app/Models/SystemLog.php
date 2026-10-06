<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['log_type', 'message'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }
}
