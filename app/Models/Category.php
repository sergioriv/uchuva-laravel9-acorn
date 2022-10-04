<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'restaurant_id',
        'name'
    ];

    /* PARENTS */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /* CHILDREN */
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
