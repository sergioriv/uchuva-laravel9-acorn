<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'finished',
        'total',
    ];

    protected $hidden = [
        'restaurant_id',
        'table_id',
        'waiter_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
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
