<?php

namespace App\Models;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Testimonial
 *
 * @property-read mixed $services_image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @mixin \Eloquent
 */
class Services  extends Model implements HasMedia
{
    use InteractsWithMedia;
    public const PATH = 'services';

     /**
     * Validation rules
     *
     * @var array
     */

    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'services_image' => 'required|mimes:jpeg,jpg,png',
    ];

    public $table = 'services';

    public $fillable = [
        'name',
        'description',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
    ];
    /**
     * @var array
     */
    protected $appends = ['services_image_url'];

       /**
     * @return mixed
     */
    public function getServicesImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return asset('assets/img/infyom-logo.png');
    }

}
