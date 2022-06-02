<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends CastCreateModel
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'quantity',
        'payment_date',
        'unsubscribe'
    ];

    protected $casts = [
        'payment_date' => 'datetime:Y-m-d',
        'unsubscribe' => 'datetime:Y-m-d',
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

}
