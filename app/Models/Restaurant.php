<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'unsubscribe',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suscriptions()
    {
        return $this->hasMany(Suscription::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function waiters()
    {
        return $this->hasMany(Waiter::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
