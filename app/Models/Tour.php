<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
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
    protected $append = [
        'thumbnail',
        'short_description',
    ];

    /**
     * @return string
     */
    public function getShortDescriptionAttribute(): string
    {
        $description = $this->trixRichText()->first()->content;
        return strlen(strip_tags($description)) > 100 ? substr(strip_tags($description), 0, 100) . '...' : strip_tags($description);
    }

    public function getThumbnailAttribute(): string
    {
        return $this->images()->first() ? url($this->images()->first()->path) : asset('assets/img/image-placeholder.jpg');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($model) {
            $model->trixRichText()->delete();
            $model->trixAttachments()->delete();
        });
    }

    /**
     * When creating a new model, if the slug field is empty, then generate a slug from the name field.
     *
     * @return array An array of configuration options for the sluggable behavior.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function facility(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Facility::class, 'facilityable');
    }
}
