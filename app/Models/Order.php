<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'restaurant_id',
        'table_id',
        'waiter_id',
        'code',
        'finished',
        'total',
    ];

    /* PARENTS */
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
        return $this->belongsTo(Waiter::class)->with('user');
    }

    /* CHILDREN */
    public function dishes()
    {
        return $this->hasMany(OrderDish::class);
    }
}
