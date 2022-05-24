<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'quantity',
        'payment_date',
        'unsubscribe'
    ];

    protected $casts = [
        'payment_date'  => 'datetime:Y-m-d h:i:s',
        'unsubscribe'   => 'datetime:Y-m-d',
        'created_at'    => 'datetime:Y-m-d h:i:s',
        'updated_at'    => 'datetime:Y-m-d h:i:s',
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
