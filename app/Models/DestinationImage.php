<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinationImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'destination_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'destination_id',
        'image_url',
    ];

    /**
     * The destination that the image belongs to.
     */

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

}
