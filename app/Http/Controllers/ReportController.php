<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\HrisEmployee;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{
    /**
     * Filter assessment berdasarkan tahun, kuartal,
     * dan departemen.
     */
    private function applyFilters(Builder $query, Request $request): Builder
    {
        if ($request->filled('year')) {
            $query->where('period_year', $request->year);
        }

        if ($request->filled('quarter')) {
            $query->where('period_quarter', $request->quarter);
        }

        if ($request->filled('department')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where(
                    'department',
                    'like',
                    '%' . $request->department . '%'
                );
            });
        }

        return $query;
    }

    /**
     * Pilihan filter laporan.
     */
    private function filterOptions(): array
    {
        return [
            'years' => Assessment::query()
                ->whereNotNull('period_year')
                ->distinct()
                ->orderByDesc('period_year')
                ->pluck('period_year'),

            'departments' => HrisEmployee::query()
                ->whereNotNull('department')
                ->where('department', '!=', '')
                ->distinct()
                ->orderBy('department')
                ->pluck('department'),
        ];
    }

    /**
     * Halaman Skill Gap Analysis.
     */
    public function skillGap(Request $request)
    {
        $query = Assessment::with(['employee', 'skill'])
            ->whereColumn('assessed_level', '<', 'target_level');

        $this->applyFilters($query, $request);

        $assessments = $query
            ->orderBy('employee_id')
            ->orderByDesc('period_year')
            ->orderByDesc('period_quarter')
            ->orderByDesc('target_level')
            ->paginate(100)
            ->withQueryString();

        $totalGap = (clone $query)->count();

        $averageGap = (clone $query)
            ->reorder()
            ->selectRaw('AVG(target_level - assessed_level) as average_gap')
            ->value('average_gap');

        $filterOptions = $this->filterOptions();

        return view('reports.skill-gap', compact(
            'assessments',
            'totalGap',
            'averageGap',
            'filterOptions'
        ));
    }

    /**
     * Halaman Laporan Assessment.
     */
    public function index(Request $request)
    {
        // Query utama untuk tabel laporan.
        $query = Assessment::with(['employee', 'skill']);

        $this->applyFilters($query, $request);

        $assessments = (clone $query)
            ->orderBy('employee_id')
            ->orderByDesc('period_year')
            ->orderByDesc('period_quarter')
            ->orderBy('assessed_at')
            ->paginate(100)
            ->withQueryString();

        // Jumlah karyawan dari database HRIS.
        $employeeCount = HrisEmployee::count();

        // Jumlah skill.
        $skillCount = Skill::count();

        // Total penilaian skill sesuai filter.
        $assessmentCount = (clone $query)->count();

        // Query bersih khusus ringkasan dan grafik.
        $summaryQuery = Assessment::query();

        $this->applyFilters($summaryQuery, $request);

        // Distribusi level aktual.
        $levelSummary = (clone $summaryQuery)
            ->selectRaw('assessed_level, COUNT(*) as total')
            ->groupBy('assessed_level')
            ->orderBy('assessed_level')
            ->get();

        // Jumlah assessment per kuartal.
        $quarterSummary = (clone $summaryQuery)
            ->selectRaw(
                'period_year, period_quarter, COUNT(*) as total'
            )
            ->whereNotNull('period_year')
            ->whereNotNull('period_quarter')
            ->groupBy('period_year', 'period_quarter')
            ->orderBy('period_year')
            ->orderBy('period_quarter')
            ->get();

        // Assessment yang mencapai target.
        $achievedCount = (clone $summaryQuery)
            ->whereColumn('assessed_level', '>=', 'target_level')
            ->count();

        // Assessment yang masih memiliki gap.
        $gapCount = (clone $summaryQuery)
            ->whereColumn('assessed_level', '<', 'target_level')
            ->count();

        $filterOptions = $this->filterOptions();

        return view('reports.index', compact(
            'assessments',
            'employeeCount',
            'skillCount',
            'assessmentCount',
            'levelSummary',
            'quarterSummary',
            'achievedCount',
            'gapCount',
            'filterOptions'
        ));
    }
}