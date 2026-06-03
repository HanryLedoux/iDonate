<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'event_date', 'location', 'image_path', 'user_id'];

    protected $casts = [
        'event_date' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function eventFoodItems()
    {
        return $this->hasMany(EventFoodItem::class);
    }

    public function foodItems()
    {
        return $this->belongsToMany(FoodItem::class, 'event_food_items')->withPivot('stock_status')->withTimestamps();
    }
}
