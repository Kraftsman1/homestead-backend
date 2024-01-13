<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'description',
        'city_id',
        'region_id',
        'country_id',
        'zip_code',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the images for the destination.
     */

    public function images()
    {
        return $this->hasMany(DestinationImage::class);
    }

    /**
     * Get the city that owns the destination.
     */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the region that owns the destination.
     */

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the country that owns the destination.
     */
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the properties for the destination.
     */

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get the amenities for the destination.
     */

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'destination_amenities');
    }

    public function markAsFeatured()
    {
        $this->featured = true;
        $this->save();
    }

}
