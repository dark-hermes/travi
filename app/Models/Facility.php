<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;
    use HasTrixRichText;

    /**
     * @var array<int, string>
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->trixRichText()->delete();
            $model->trixAttachments()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function facilityable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
