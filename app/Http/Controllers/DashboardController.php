<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\HrisEmployee;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // TOTAL KARYAWAN LANGSUNG DARI DATABASE HRIS
        $employeeCount = HrisEmployee::count();

        // DATA SKILL MATRIX
        $skillCount = Skill::where('is_active', true)->count();

        $assessmentCount = Assessment::count();

        $gapCount = Assessment::whereColumn(
            'assessed_level',
            '<',
            'target_level'
        )->count();

        // ASSESSMENT TERBARU
        $assessments = Assessment::with(['employee', 'skill'])
            ->latest('assessed_at')
            ->take(7)
            ->get();

        // DAFTAR SKILL AKTIF
        $skills = Skill::withCount('assessments')
            ->where('is_active', true)
            ->orderBy('name')
            ->take(8)
            ->get();

        // RATA-RATA KOMPETENSI
        $average = round(
            (float) (Assessment::query()->avg('assessed_level') ?? 0) / 5 * 100
        );

        // DISTRIBUSI LEVEL SKILL
        $levels = [
            'Pemula' => Assessment::where('assessed_level', 1)->count(),
            'Dasar' => Assessment::where('assessed_level', 2)->count(),
            'Menengah' => Assessment::where('assessed_level', 3)->count(),
            'Mahir' => Assessment::where('assessed_level', 4)->count(),
            'Ahli' => Assessment::where('assessed_level', 5)->count(),
        ];

        // DATA GRAFIK ASSESSMENT PER KUARTAL
        $quarterlyRows = Assessment::query()
            ->selectRaw('period_year, period_quarter, COUNT(*) as total')
            ->whereNotNull('period_year')
            ->whereNotNull('period_quarter')
            ->groupBy('period_year', 'period_quarter')
            ->orderBy('period_year')
            ->orderBy('period_quarter')
            ->get();

        $quarterlyLabels = $quarterlyRows->map(function ($row) {
            return 'Q' . $row->period_quarter . ' ' . $row->period_year;
        })->values();

        $quarterlyTotals = $quarterlyRows
            ->pluck('total')
            ->map(fn ($total) => (int) $total)
            ->values();

        return view('dashboard', compact(
            'employeeCount',
            'skillCount',
            'assessmentCount',
            'gapCount',
            'assessments',
            'skills',
            'average',
            'levels',
            'quarterlyRows',
            'quarterlyLabels',
            'quarterlyTotals'
        ));
    }
}