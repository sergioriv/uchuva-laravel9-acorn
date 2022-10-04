<?php

namespace App\Models;

use App\Traits\uuid;
use Carbon\Carbon;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable /* implements MustVerifyEmail */
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];


    /**
     * Mutadores y Accesores
     */

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords(strtolower($value)),
        );
    }

    /* protected function emailVerifiedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value, 'UTC')->timezone(config('app.timezone'))->format('Y-m-d H:i:s')
        );
    } */

    /* protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value, 'UTC')->timezone(config('app.timezone'))->format('Y-m-d H:i:s')
        );
    } */
}
