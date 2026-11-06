<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Skill;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    /**
     * Menampilkan seluruh data assessment.
     */
    
public function index(Request $request)
{
    $query = Assessment::with(['employee', 'skill']);

    if ($request->filled('year')) {
        $query->where('period_year', $request->year);
    }

    if ($request->filled('quarter')) {
        $query->where('period_quarter', $request->quarter);
    }

    if ($request->filled('department')) {
        $query->whereHas('employee', function ($q) use ($request) {
            $q->where('department', 'like', '%' . $request->department . '%');
        });
    }

    $assessments = $query
        ->orderBy('employee_id')
        ->orderByDesc('period_year')
        ->orderByDesc('period_quarter')
        ->orderBy('assessed_at')
        ->paginate(100)
        ->withQueryString();

    $groupedAssessments = $assessments->getCollection()
        ->groupBy(function ($assessment) {
            return $assessment->employee_id . '-' .
                $assessment->period_year . '-' .
                $assessment->period_quarter;
        });

    $totalAssessment = $assessments->total();

    return view('assessments.index', compact(
        'assessments',
        'groupedAssessments',
        'totalAssessment'
    ));
}


    /**
     * Form tambah assessment.
     */
    public function create()
    {
        return view('assessments.form', [
            'assessment' => new Assessment(),
            'skills' => Skill::where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    /**
     * Menyimpan assessment baru.
     */
    public function store(Request $request)
    {
        $data = $this->validated($request);

        $date = \Illuminate\Support\Carbon::parse($data['assessed_at']);

        $data['period_year'] = (int) $date->year;
        $data['period_quarter'] = (int) ceil($date->month / 3);

        $existing = Assessment::where('employee_id', $data['employee_id'])
            ->where('skill_id', $data['skill_id'])
            ->where('period_year', $data['period_year'])
            ->where('period_quarter', $data['period_quarter'])
            ->exists();

        if ($existing) {
            return back()
                ->withInput()
                ->withErrors([
                    'skill_id' => 'Skill ini sudah dinilai untuk karyawan dan periode tersebut. Silakan edit assessment yang sudah ada.',
                ]);
        }

        Assessment::create($data);

        return redirect()
            ->route('assessments.index')
            ->with('success', 'Assessment berhasil disimpan.');
    }

    /**
     * Form edit assessment.
     */
    public function edit(Assessment $assessment)
    {
        $assessment->load(['employee', 'skill']);

        return view('assessments.form', [
            'assessment' => $assessment,
            'skills' => Skill::where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    /**
     * Memperbarui assessment.
     */
    public function update(Request $request, Assessment $assessment)
    {
        $data = $this->validated($request);

        $date = \Illuminate\Support\Carbon::parse($data['assessed_at']);

        $data['period_year'] = (int) $date->year;
        $data['period_quarter'] = (int) ceil($date->month / 3);

        $duplicate = Assessment::where('employee_id', $data['employee_id'])
            ->where('skill_id', $data['skill_id'])
            ->where('period_year', $data['period_year'])
            ->where('period_quarter', $data['period_quarter'])
            ->where('id', '!=', $assessment->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'skill_id' => 'Assessment untuk skill dan periode tersebut sudah tersedia.',
                ]);
        }

        $assessment->update($data);

        return redirect()
            ->route('assessments.index')
            ->with('success', 'Assessment berhasil diperbarui.');
    }

    /**
     * Menghapus assessment.
     */
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();

        return redirect()
            ->route('assessments.index')
            ->with('success', 'Assessment berhasil dihapus.');
    }

    /**
     * Validasi data assessment.
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'employee_id' => [
                'required',
                'integer',
                'exists:employees,id',
            ],

            'skill_id' => [
                'required',
                'integer',
                'exists:skills,id',
            ],

            'assessed_level' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'target_level' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'assessed_at' => [
                'required',
                'date',
            ],

            'assessor' => [
                'nullable',
                'string',
                'max:150',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);
    }
}