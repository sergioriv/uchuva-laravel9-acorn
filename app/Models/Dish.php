<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends CastCreateModel
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'category_id',
        'name',
        'description',
        'price',
        'quality',
        'available'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name');
    }
}
