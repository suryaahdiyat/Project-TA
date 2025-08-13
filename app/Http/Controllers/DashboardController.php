<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function dashboard(Request $request)
    {
        $year = $request->get('year', now()->year); // default tahun ini kalau tidak diinput

        $today = \Carbon\Carbon::now();

        // Data groom umur < 18 tahun berdasarkan tahun pernikahan inputan
        $groomUnder18 = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->whereRaw('DATE_ADD(couples.groom_birth_date, INTERVAL 18 YEAR) > schedules.marriage_date')
            ->count();

        // Data groom umur >= 18 tahun
        $groom18AndAbove = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->whereRaw('DATE_ADD(couples.groom_birth_date, INTERVAL 18 YEAR) <= schedules.marriage_date')
            ->count();

        // Rata-rata usia mempelai pria saat menikah
        $averageGroomAge = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, couples.groom_birth_date, schedules.marriage_date)) as average_age')
            ->value('average_age');

        // Rata-rata usia mempelai wanita saat menikah
        $averageBrideAge = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, couples.bride_birth_date, schedules.marriage_date)) as average_age')
            ->value('average_age');

        // Data bride umur < 18 tahun
        $brideUnder18 = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->whereRaw('DATE_ADD(couples.bride_birth_date, INTERVAL 18 YEAR) > schedules.marriage_date')
            ->count();

        // Data bride umur >= 18 tahun
        $bride18AndAbove = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->whereRaw('DATE_ADD(couples.bride_birth_date, INTERVAL 18 YEAR) <= schedules.marriage_date')
            ->count();

        // Nikah bulan ini (filter tahun juga)
        $marriagesThisMonth = DB::table('schedules')
            ->whereYear('marriage_date', $year)
            ->whereMonth('marriage_date', now()->month)
            ->count();

        // Nikah tahun ini (tahun sesuai inputan)
        $marriagesThisYear = DB::table('schedules')
            ->whereYear('marriage_date', $year)
            ->count();

        // Marriage status group (filter berdasarkan tahun pernikahan)
        $statusStats = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->select('marriage_status', DB::raw('count(*) as total'))
            ->groupBy('marriage_status')
            ->pluck('total', 'marriage_status');

        // Groom religion
        $groomReligions = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->select('groom_religion', DB::raw('count(*) as total'))
            ->groupBy('groom_religion')
            ->pluck('total', 'groom_religion');

        // Bride religion
        $brideReligions = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->select('bride_religion', DB::raw('count(*) as total'))
            ->groupBy('bride_religion')
            ->pluck('total', 'bride_religion');

        // Groom nationality
        $groomNationalities = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->select('groom_nationality', DB::raw('count(*) as total'))
            ->groupBy('groom_nationality')
            ->pluck('total', 'groom_nationality');

        // Bride nationality
        $brideNationalities = DB::table('couples')
            ->join('schedules', 'couples.id', '=', 'schedules.couple_id')
            ->whereYear('schedules.marriage_date', $year)
            ->select('bride_nationality', DB::raw('count(*) as total'))
            ->groupBy('bride_nationality')
            ->pluck('total', 'bride_nationality');

        // Monthly marriages grouped by month for the year
        $rawMonthlyMarriages = DB::table('schedules')
            ->whereYear('marriage_date', $year)
            ->select(
                DB::raw('MONTH(marriage_date) as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            // ->orderBy('month')
            ->pluck('total', 'month');

        // Isi data agar semua bulan (1–12) tetap tampil, walaupun tidak ada datanya (isi 0)
        $monthlyMarriages = collect();
        foreach (range(1, 12) as $month) {
            $monthlyMarriages[$month] = $rawMonthlyMarriages[$month] ?? 0;
        }

        $rawYearlyMarriages = DB::table('schedules')
            ->select(DB::raw('YEAR(marriage_date) as year'), DB::raw('count(*) as total'))
            ->whereBetween(DB::raw('YEAR(marriage_date)'), [$year - 9, $year])
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year'); // hasilnya seperti: [2023 => 12, 2025 => 9]
        // Lengkapi data agar tahun kosong diisi 0
        $yearlyMarriages = collect();
        foreach (range($year - 9, $year) as $yearR) {
            $yearlyMarriages[$yearR] = $rawYearlyMarriages[$yearR] ?? 0;
        }

        return view('pages.dashboard', compact(
            'groomUnder18',
            'groom18AndAbove',
            'averageGroomAge',
            'averageBrideAge',
            'brideUnder18',
            'bride18AndAbove',
            'marriagesThisMonth',
            'marriagesThisYear',
            'statusStats',
            'groomReligions',
            'brideReligions',
            'groomNationalities',
            'brideNationalities',
            'monthlyMarriages',
            'yearlyMarriages',
            'year'
        ));
    }
}
