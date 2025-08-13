<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'Announcements';
    protected $guarded = ['id'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function themeView()
    {
        return $this->belongsTo(ThemeView::class);
    }
}
