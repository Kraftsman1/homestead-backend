<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * 
     * @var string
     */

    protected $table = 'regions';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'country_id',
    ];

    /**
     * Get the country that owns the region.
     */

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the cities for the region.
     */

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
