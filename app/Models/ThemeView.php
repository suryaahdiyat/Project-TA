<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeView extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::deleting(function ($theme) {
            // Cari tema pengganti yang lain
            $replacement = ThemeView::where('id', '!=', $theme->id)->first();

            // Update semua announcement ke tema pengganti atau null jika tidak ada
            \App\Models\Announcement::where('theme_view_id', $theme->id)
                ->update(['theme_view_id' => optional($replacement)->id]);
        });
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}
