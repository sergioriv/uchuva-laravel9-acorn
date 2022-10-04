<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'telephone'
    ];

    /* PARENTS */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id','name','email', 'avatar');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

}
