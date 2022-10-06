<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'restaurant_id',
        'category_id',
        'image',
        'name',
        'description',
        'price',
        'quality',
        'available'
    ];

    /* PARENTS */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* CHILDREN */
    public function orders()
    {
        return $this->hasMany(OrderDish::class, 'dish_id');
    }
}
