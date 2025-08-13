<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $fillable = ['type', 'synced_at'];
    public $timestamps = true;

    protected $casts = [
        'synced_at' => 'datetime',
    ];
}
