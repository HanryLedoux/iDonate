<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = ['company_id', 'event_id', 'title', 'description', 'quantity', 'image_path', 'is_available'];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
