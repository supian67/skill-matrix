
@extends('layouts.app')

@section('title', 'Assessment')

@section('content')

<style>
.assessment-page {
    color: #243247;
}

.assessment-page .page-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

.assessment-page h1 {
    margin: 0;
    font-size: 25px;
    color: #123e68;
}

.assessment-page .muted {
    color: #8492a6;
    font-size: 13px;
    margin-top: 5px;
}

.assessment-page .card {
    background: #fff;
    border: 1px solid #e5eaf0;
    border-radius: 13px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(18,62,104,.04);
}

.assessment-page .filter {
    padding: 20px;
}

.assessment-page .filter-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0,1fr));
    gap: 14px;
    align-items: end;
}

.assessment-page label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 7px;
}

.assessment-page input,
.assessment-page select {
    width: 100%;
    min-height: 40px;
    border: 1px solid #d7e0ea;
    border-radius: 8px;
    padding: 9px 11px;
    box-sizing: border-box;
}

.assessment-page .btn {
    border: 0;
    border-radius: 8px;
    padding: 9px 14px;
    background: #123e68;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-block;
}

.assessment-page .btn.light {
    background: #edf3f9;
    color: #1769aa;
}

.assessment-page .btn.danger {
    background: #fff0ef;
    color: #c0392b;
}

.assessment-page .employee-group {
    margin-bottom: 18px;
    border: 1px solid #e5eaf0;
    border-radius: 12px;
    overflow: hidden;
}

.assessment-page .employee-header {
    padding: 18px 20px;
    background: #f2f7fc;
    border-bottom: 1px solid #e5eaf0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.assessment-page .employee-name {
    font-size: 16px;
    font-weight: 700;
    color: #123e68;
}

.assessment-page .employee-meta {
    color: #718096;
    font-size: 13px;
    margin-top: 5px;
}

.assessment-page .period-badge {
    background: #e1efff;
    color: #1769aa;
    border-radius: 20px;
    padding: 7px 12px;
    font-size: 12px;
    font-weight: 700;
}

.assessment-page .skill-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

.assessment-page .skill-table th {
    background: #fafbfd;
    color: #64748b;
    text-align: left;
    padding: 12px;
    font-size: 12px;
}

.assessment-page .skill-table td {
    padding: 13px 12px;
    border-top: 1px solid #edf0f4;
    font-size: 13px;
}

.assessment-page .badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.assessment-page .badge.warning {
    background: #fff4dc;
    color: #a66b00;
}

.assessment-page .badge.success {
    background: #e8f7ed;
    color: #187443;
}

.assessment-page .group-footer {
    padding: 13px 18px;
    background: #fafbfd;
    border-top: 1px solid #edf0f4;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}

.assessment-page .pagination {
    padding: 18px;
}

.assessment-page .empty {
    padding: 35px;
    text-align: center;
    color: #8492a6;
}

.assessment-page .table-wrap {
    overflow-x: auto;
}

@media(max-width: 800px) {
    .assessment-page .filter-grid {
        grid-template-columns: repeat(2, minmax(0,1fr));
    }
}

@media(max-width: 550px) {
    .assessment-page .filter-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="assessment-page">

    {{-- HEADER --}}
    <div class="page-head">
        <div>
            <div class="muted">ASSESSMENT KOMPETENSI</div>
            <h1>Penilaian Skill Karyawan</h1>
            <div class="muted">
                Rekap beberapa kompetensi dalam satu periode penilaian.
            </div>
        </div>

        <a href="{{ route('assessments.create') }}" class="btn">
            ＋ Input Assessment
        </a>
    </div>

    {{-- TOTAL ASSESSMENT --}}
    <div class="card filter">
        <div class="muted">TOTAL ASSESSMENT (JUMLAH SKILL DINILAI)</div>
        <div style="font-size:30px;font-weight:800;color:#123e68;margin-top:5px">
            {{ number_format($totalAssessment) }}
        </div>
        <div class="muted">
            Jumlah seluruh baris penilaian sesuai filter yang dipilih.
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card filter">
        <form method="GET" action="{{ route('assessments.index') }}">
            <div class="filter-grid">

                <div>
                    <label>Tahun</label>
                    <select name="year">
                        <option value="">Semua Tahun</option>
                        @foreach(range(now()->year, now()->year - 5) as $year)
                            <option value="{{ $year }}"
                                {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Kuartal</label>
                    <select name="quarter">
                        <option value="">Semua Kuartal</option>
                        @foreach([1,2,3,4] as $quarter)
                            <option value="{{ $quarter }}"
                                {{ request('quarter') == $quarter ? 'selected' : '' }}>
                                Q{{ $quarter }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Departemen</label>
                    <input
                        type="text"
                        name="department"
                        placeholder="Cari departemen"
                        value="{{ request('department') }}"
                    >
                </div>

                <div style="display:flex;gap:8px">
                    <button type="submit" class="btn">Filter</button>
                    <a href="{{ route('assessments.index') }}" class="btn light">Reset</a>
                </div>

            </div>
        </form>
    </div>

    {{-- KELOMPOK KARYAWAN --}}
    @forelse($groupedAssessments as $group)

        @php
            $first = $group->first();
            $employee = $first->employee;
            $totalSkill = $group->count();
            $totalGap = $group->sum('gap');
        @endphp

        <div class="employee-group">

            <div class="employee-header">
                <div>
                    <div class="employee-name">
                        {{ $employee->name ?? '-' }}
                    </div>

                    <div class="employee-meta">
                        {{ $employee->employee_no ?? '-' }}
                        &nbsp; | &nbsp;
                        {{ $employee->department ?? '-' }}
                    </div>
                </div>

                <div class="period-badge">
                    {{ $first->period_label }}
                </div>
            </div>

            <div class="table-wrap">
                <table class="skill-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kompetensi / Skill</th>
                            <th>Level Aktual</th>
                            <th>Target</th>
                            <th>Gap</th>
                            <th>Tanggal</th>
                            <th>Assessor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($group as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <b>{{ $a->skill->name ?? '-' }}</b>
                                </td>

                                <td>
                                    <b>{{ $a->assessed_level }}/5</b>
                                </td>

                                <td>{{ $a->target_level }}/5</td>

                                <td>
                                    @if($a->gap > 0)
                                        <span class="badge warning">
                                            -{{ $a->gap }}
                                        </span>
                                    @else
                                        <span class="badge success">
                                            Tercapai
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $a->assessed_at?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>{{ $a->assessor ?: '-' }}</td>

                                <td>
                                    <a
                                        href="{{ route('assessments.edit', $a) }}"
                                        class="btn light"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('assessments.destroy', $a) }}"
                                        style="display:inline"
                                        onsubmit="return confirm('Hapus assessment ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn danger" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="group-footer">
                <div>
                    Total skill dinilai:
                    <b>{{ $totalSkill }} Skill</b>
                </div>

                <div>
                    Total gap:
                    <b>{{ $totalGap }}</b>
                </div>
            </div>

        </div>

    @empty

        <div class="card empty">
            Belum ada data assessment untuk filter tersebut.
        </div>

    @endforelse

    {{-- PAGINATION --}}
    <div class="pagination">
        {{ $assessments->links() }}
    </div>

</div>

@endsection