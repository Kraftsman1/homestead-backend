<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'region_id',
    ];

    /**
     * Get the region that owns the city.
     */

    public function region()
    {
        return $this->belongsTo(Region::class);
    }



}