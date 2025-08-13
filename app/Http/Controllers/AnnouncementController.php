<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AnnouncementController extends Controller
{

    public function sync(): RedirectResponse
    {
        // Jalankan command artisan
        Artisan::call('app:sync-announcement');

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Sinkronisasi pengumuman berhasil dijalankan.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'Announcement.index',
            [
                'announcements' => Announcement::with('schedule.couple')->join('schedules', 'schedules.id', '=', 'announcements.schedule_id')
                    ->orderBy('schedules.marriage_date', 'asc') // Atur urutan berdasarkan marriage_date
                    ->orderBy('schedules.marriage_time', 'asc')
                    ->paginate(10)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }

    public function viewAnnouncement()
    {
        return view('announcement.view-announcement', [
            'announcements' => Announcement::with('schedule.couple')->join('schedules', 'schedules.id', '=', 'announcements.schedule_id')
                ->orderBy('schedules.marriage_date', 'asc') // Atur urutan berdasarkan marriage_date
                ->get()
        ]);
    }
}
