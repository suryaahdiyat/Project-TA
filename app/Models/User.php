<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'role',
        'is_active'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function BusyHour()
    {
        return $this->hasMany(BusyHour::class)->orderBy('date')->orderBy('time');;
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    // Ambil hanya penghulu aktif
    public function scopeActivePenghulu($query)
    {
        return $query->where('role', 'penghulu')->where('is_active', true);
    }

    // Ambil hanya admin aktif
    public function scopeActiveAdmin($query)
    {
        return $query->where('role', 'admin')->where('is_active', true);
    }
}
