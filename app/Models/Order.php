<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends CastCreateModel
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'table_id',
        'waiter_id',
        'code',
        'finished',
        'total',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class)->select('id', 'reference');
    }

    public function waiter()
    {
        return $this->belongsTo(Waiter::class);
    }

    public function dishes()
    {
        return $this->hasMany(OrderDish::class);
    }
}
