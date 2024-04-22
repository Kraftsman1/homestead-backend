<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAvailability extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'property_availability';

    protected $fillable = [
        'property_id',
        'date',
        'available',
        'minimum_stay',
        'maximum_stay',
        // Optional: Per-day pricing
        'price',
    ];

    /**
     * Get the property that this availability belongs to.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Additional methods (Optional)

    public function getFormattedPrice()
    {
        // (Optional) This method could format the price for display
        return 'GHC ' . number_format($this->price, 2);
    }
}
