<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends CastCreateModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'restaurant_id',
        'branch_id',
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
