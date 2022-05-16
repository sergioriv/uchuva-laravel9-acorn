<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    use HasFactory;

    protected $hidden = [
        'restaurant_id',
        'quantity',
        'unsubscribe'
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
