<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'destinations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [

        'name',
        'description',
        'city_id',
        'region_id',
        'country_id',
        'zip_code',
        'image_url'

    ];

    /**
     * Get the images for the destination.
     */

    public function images()
    {
        return $this->hasOne(DestinationImage::class);
    }

}
