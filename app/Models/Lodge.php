<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lodge extends Model
{
    use HasFactory;
    use Sluggable;
    use HasTrixRichText;

    /**
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'thumbnail',
        'short_description',
    ];

    /**
     * @return string
     */
    public function getThumbnailAttribute(): string
    {
        return $this->images()->first() ? url($this->images()->first()->path) : asset('assets/img/image-placeholder.jpg');
    }

    /**
     * @return string
     */
    public function getShortDescriptionAttribute(): string
    {
        $description = $this->trixRichText()->first()->content;
        return strlen(strip_tags($description)) > 100 ? substr(strip_tags($description), 0, 100) . '...' : strip_tags($description);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->trixRichText()->delete();
            $model->trixAttachments()->delete();
        });
    }

    /* A method that is used by the `Sluggable` trait to generate a slug for the model. */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function facility(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Facility::class, 'facilityable');
    }
}
