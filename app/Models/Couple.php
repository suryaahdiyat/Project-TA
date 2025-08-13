<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couple extends Model
{
    //
    protected $guarded = ['id'];

    // app/Models/Couple.php

    public function scopeRegistered($query)
    {
        return $query->where('marriage_status', 'terdaftar');
    }
}
