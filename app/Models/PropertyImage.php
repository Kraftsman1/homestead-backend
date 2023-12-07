<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */

    protected $table = 'property_images';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */

    protected $fillable = [
        'property_id',
        'image_url',
    ];

    /**
     * The property that the image belongs to.
     */

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

}
