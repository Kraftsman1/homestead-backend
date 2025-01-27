<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * 
     * @var string
     */

    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'code', 
    ];

    // public function destinations()
    // {
    //     return $this->hasMany(Destination::class);
    // }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get the regions for the country.
     */

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    /**
     * Get the cities for the country.
     */

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
