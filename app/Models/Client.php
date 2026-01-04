<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'clients';

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function bookings()
    {
        return $this->hasMany(CourseBooking::class);
    }
}
