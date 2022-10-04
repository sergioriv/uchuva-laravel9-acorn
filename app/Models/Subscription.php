<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'restaurant_id',
        'quantity',
        'payment_date',
        'unsubscribe'
    ];

    /* PARENTS */
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

}
