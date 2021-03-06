<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends CastCreateModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'restaurant_id',
        'code',
        'city',
        'address',
        'telephone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id')->select(['id','name','email', 'avatar']);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function waiters()
    {
        return $this->hasMany(Waiter::class)->with('user');
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
