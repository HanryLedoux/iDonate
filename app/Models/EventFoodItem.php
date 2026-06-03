<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFoodItem extends Model
{
    protected $fillable = ['event_id', 'food_item_id', 'stock_status'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }
}
