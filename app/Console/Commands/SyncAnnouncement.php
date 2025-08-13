<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\Couple;
use App\Models\Schedule;
use App\Models\SyncLog;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SyncAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-announcement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus announcement jika melewati tanggal akad';

    /**
     * Execute the console command.
     */

    // public function handle()
    // {
    //     $today = Carbon::today();

    //     // Hapus pengumuman yang jadwalnya sudah lewat
    //     Announcement::whereHas('schedule', function ($q) use ($today) {
    //         $q->whereDate('marriage_date', '<', $today);
    //     })->delete();

    //     // Masukkan pengumuman untuk jadwal hari ini
    //     $schedules = Schedule::whereDate('marriage_date', '>=',  $today)->get();

    //     foreach ($schedules as $schedule) {
    //         Announcement::updateOrCreate(
    //             ['schedule_id' => $schedule->id],
    //             // ['templateView' => 'default-template'] // Sesuaikan jika perlu
    //         );
    //     }

    //     $this->info('Pengumuman yang sudah lewat tanggal akad berhasil dihapus.');
    // }

    public function handle()
    {
        $today = Carbon::today();

        // Cari semua Schedule yang tanggal akadnya sudah lewat
        $expiredSchedules = Schedule::whereDate('marriage_date', '<', $today)->get();

        foreach ($expiredSchedules as $schedule) {
            // Update status marriage pada couple terkait
            if ($schedule->couple) {
                $schedule->couple->marriage_status = 'selesai';
                $schedule->couple->save();
            }

            // Hapus busy hours terkait schedule yang sudah expired
            // DB::table('busy_hours')->where('schedule_id', $schedule->id)->delete();
            $schedule->busyHour()?->delete();
        }

        Announcement::whereHas('schedule', function ($q) use ($today) {
            $q->whereDate('marriage_date', '<', $today);
        })->delete();

        $schedules = Schedule::whereDate('marriage_date', '>=',  $today)->get();


        foreach ($schedules as $schedule) {
            Announcement::updateOrCreate(
                ['schedule_id' => $schedule->id]
            );
        }

        // Simpan waktu sinkronisasi
        SyncLog::create([
            'type' => 'announcement',
            'synced_at' => now(),
        ]);

        $this->info('Sinkronisasi selesai.');
    }
}
