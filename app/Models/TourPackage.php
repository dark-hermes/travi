<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class TourPackage extends Model
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
        'discount_price',
        'price_after_discount',
        'visitors'
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
    public function getDiscountPriceAttribute(): string
    {
        return $this->price * $this->discount / 100;
    }

    /**
     * @return string
     */
    public function getPriceAfterDiscountAttribute(): string
    {
        return $this->price - $this->discount_price;
    }

    /**
     * @return int
     */
    public function getVisitorsAttribute(): int
    {
        return $this->reservations()->where('status', 'approved')->sum('quantity');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
