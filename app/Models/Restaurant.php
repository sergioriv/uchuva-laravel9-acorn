<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'nit',
        'telephone',
    ];

    protected $casts = [
        'unsubscribe' => 'datetime:Y-m-d',
    ];

    /* CHILDREN */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id','name','email', 'avatar');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
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


    /**
     * Mutadores y Accesores
     */

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
            set: fn ($value) => strtolower($value),
        );
    }
}
