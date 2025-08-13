<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusyHour extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
