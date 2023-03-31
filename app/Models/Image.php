<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public static function store($file, $dir, $model, $singular = false)
    {
        $newName = time() . str()->random(8) . $model->id . '.' . $file->getClientOriginalExtension();

        while (Image::where('path', $newName)->exists()) {
            $newName = time() . str()->random(8) . $model->id . '.' . $file->getClientOriginalExtension();
        }

        $file->move(storage_path('app/public/' . $dir), $newName);

        // $singular
        //     ? $model->image()->create(['path' => 'storage/' . $dir . '/' . $newName])
        //     : $model->images()->create(['path' => 'storage/' . $dir . '/' . $newName]);
        if ($singular) {
            if ($model->image) {
                Image::purge($model->image);
            }
            $model->image()->create(['path' => 'storage/' . $dir . '/' . $newName]);
        } else {
            $model->images()->create(['path' => 'storage/' . $dir . '/' . $newName]);
        }
    }

    public static function purge($image)
    {
        Storage::delete('public/' . $image->path);
        $image->delete();
    }
}
