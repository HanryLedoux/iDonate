<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = ['company_id', 'title', 'description', 'quantity', 'image_path', 'is_available', 'expiry_date'];

    protected $casts = [
        'is_available' => 'boolean',
        'expiry_date'  => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
