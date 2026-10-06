<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstituteConfiguration extends Model
{
    protected $table = 'institute_configurations';

    public const UPDATED_AT = 'updated_at';

    public const CREATED_AT = null;

    protected $fillable = [
        'institute_id', 'logo_url', 'favicon_url', 'primary_color', 'secondary_color',
        'accent_color', 'background_color', 'text_color',
    ];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class,'institute_id');
    }
}
