<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    use Sluggable;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'tour_category_id',
        'name',
        'slug',
        'description',
    ];

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
        return $this->belongsTo(TourCategory::class);
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function facilities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Facility::class, 'facilityable');
    }
}
