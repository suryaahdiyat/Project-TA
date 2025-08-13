<?php

namespace App\Console\Commands;

use App\Models\Catin;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateStatusPernikahan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-status-pernikahan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pernikahan menjadi selesai jika tanggal pernikahan sudah lewat';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua catin dengan status 'terjadwal' dan tanggal pernikahan yang sudah lewat
        $catins = Catin::whereHas('jadwal', function ($query) {
            // $query->whereDate('tanggal_pernikahan', '<', Carbon::today());
            $query->whereRaw('DATE(tanggal_pernikahan) < ?', [Carbon::today()->toDateString()]);
        })->where('status_pernikahan', 'terjadwal')->get();

        foreach ($catins as $catin) {
            // Update status pernikahan menjadi 'selesai'
            $catin->status_pernikahan = 'selesai';
            $catin->save();
            $this->info("Status pernikahan telah diperbarui menjadi selesai.");
        }

        $this->info('Status pernikahan berhasil diperbarui.');
    }
    // public function handle()
    // {
    // try {
    //     $this->info('Command started.');

    //     $catins = Catin::whereHas('jadwal', function ($query) {
    //         $query->whereDate('tanggal_pernikahan', '<', Carbon::today());
    //     })->where('status_pernikahan', 'terjadwal')->get();

    //     if ($catins->isEmpty()) {
    //         $this->info('Tidak ada catin yang perlu diupdate.');
    //     }

    //     foreach ($catins as $catin) {
    //         $catin->status_pernikahan = 'selesai';
    //         $catin->save();
    //         $this->info("Status pernikahan untuk {$catin->s_name} telah diperbarui.");
    //     }

    //     $this->info('Status pernikahan berhasil diperbarui.');
    // } catch (\Exception $e) {
    //     $this->error('Terjadi kesalahan: ' . $e->getMessage());
    //     Log::error('Error UpdateStatusPernikahan: ' . $e->getMessage());
    // }

    // $catins = Catin::whereHas('jadwal', function ($query) {
    //     $query->whereDate('tanggal_pernikahan', '<', Carbon::today());
    // })->where('status_pernikahan', 'terjadwal')->get();

    // // Log data yang ditemukan
    // if ($catins->isEmpty()) {
    //     $this->info('Tidak ada catin yang perlu diupdate.');
    //     Log::info('Tidak ada catin yang perlu diupdate.');
    // } else {
    //     foreach ($catins as $catin) {
    //         $this->info("Catin ditemukan: {$catin->s_name}");
    //         Log::info("Catin ditemukan: {$catin->s_name}");
    //     }
    // }
    // }
}
