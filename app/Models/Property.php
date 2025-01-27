<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */

    protected $table = 'properties';

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected $fillable = [

        'name',
        'description',
        'property_type',
        'price',
        'bedrooms',
        'bathrooms',
        'max_guests',
        'max_guests',
        'address',
        'city_id',
        'region_id',
        'country_id',
        'latitude',
        'longitude',

    ];

    /**
     * Get the host that owns the property.
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /*
    * Get the destination that owns the property.
    */
    // public function destination()
    // {
    //     return $this->belongsTo(Destination::class);
    // }

    /*
    * Get the images for the property.
    */

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    public function availability()
    {
        return $this->hasMany(PropertyAvailability::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id');
    }

    public function getFormattedPrice()
    {
        return 'GHC ' . number_format($this->price, 2);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }

    public function availability()
    {
        return $this->hasMany(PropertyAvailability::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id');
    }

    public function getFormattedPrice()
    {
        return 'GHC ' . number_format($this->price, 2);
    }

}
