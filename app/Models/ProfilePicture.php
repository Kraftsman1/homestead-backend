<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'image_path',
        'image_url',
    ];

    /**
     * Get the user that owns the profile picture.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
