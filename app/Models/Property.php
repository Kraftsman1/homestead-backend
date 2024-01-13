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
        'type',
        'price',
        'bedrooms',
        'bathrooms',
        'address',
        'city_id',
        'region_id',
        'country_id',
        'destination_id',
        'latitude',
        'longitude',

    ];
    
    /*
    * Get the destination that owns the property.
    */

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    /*
    * Get the images for the property.
    */

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

}
