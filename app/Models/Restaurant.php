<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nit',
        'telephone',
        'unsubscribe',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'unsubscribe' => 'datetime:Y-m-d h:i:s',
        'created_at' => 'datetime:Y-m-d h:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id')->select(['id','name','email', 'avatar']);
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
        );
    }
}
