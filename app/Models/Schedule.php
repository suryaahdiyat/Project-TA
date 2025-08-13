<?php

namespace App\Models;

use Alkoumi\LaravelHijriDate\Hijri;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function announcement()
    {
        return $this->hasOne(Announcement::class);
    }

    public function getHijriDateAttribute()
    {
        // return Hijri::DateIndicDigits('l ، j F ، Y', $this->marriage_date);
        return Hijri::DateIndicDigits('Y/m/d', $this->marriage_date);
    }

    // Di model Schedule.php
    public function busyHour()
    {
        // return $this->hasOne(BusyHour::class)->orderBy('date')->orderBy('time');
        return $this->hasOne(BusyHour::class);
    }
}
