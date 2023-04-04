<?php

namespace App\Models;

use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
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
        'description',
    ];

    /**
     * @return string
     */
    public function getThumbnailAttribute(): string
    {
        // Find image from trix
        $dom = new DOMDocument();
        @$dom->loadHTML($this->trixRichText()->first()->content);
        $images = $dom->getElementsByTagName('img');
        if ($images->length > 0) {
            return url($images->item(0)->getAttribute('src'));
        }

        return asset('assets/img/image-placeholder.jpg');
    }
    /**
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        $content = $this->trixRichText()->first()->content;
        return strlen(strip_tags($content)) > 100 ? substr(strip_tags($content), 0, 100) . '...' : strip_tags($content);
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
                'source' => 'title',
            ],
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }
}
