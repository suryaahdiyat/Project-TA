<?php

use App\Console\Commands\SyncAnnouncement;
use App\Console\Commands\UpdateStatusPernikahan;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command(SyncAnnouncement::class)
    ->everyMinute(); // Ubah ke ->daily() saat production
// Schedule::command(UpdateStatusPernikahan::class)
//     ->everyMinute(); // Ubah ke ->daily() saat production
