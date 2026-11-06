@extends('layouts.app')

@section('title', 'Skill Gap Analysis')

@section('content')

<style>
.skill-gap-page {
    color: #243247;
}

.skill-gap-page .page-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

.skill-gap-page .eyebrow {
    color: #1769aa;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.skill-gap-page h1 {
    margin: 0;
    font-size: 25px;
    font-weight: 750;
    color: #123e68;
}

.skill-gap-page .muted {
    color: #718096;
    font-size: 12px;
    margin-top: 5px;
}

.skill-gap-page .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    background: #1769aa;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
}

.skill-gap-page .btn:hover {
    background: #123e68;
}

.skill-gap-page .btn-light {
    background: #edf3f9;
    color: #31516f;
}

.skill-gap-page .btn-light:hover {
    background: #dce8f3;
}

.skill-gap-page .filter-card,
.skill-gap-page .summary-card,
.skill-gap-page .table-card {
    background: #fff;
    border: 1px solid #e7edf4;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(30, 55, 90, .04);
}

.skill-gap-page .filter-card {
    padding: 17px;
    margin-bottom: 18px;
}

.skill-gap-page .filter-title {
    font-size: 14px;
    font-weight: 700;
    color: #123e68;
    margin-bottom: 13px;
}

.skill-gap-page .filter-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(150px, 1fr)) auto auto;
    gap: 12px;
    align-items: end;
}

.skill-gap-page .form-group label {
    display: block;
    font-size: 12px;
    font-weight: 650;
    color: #53657a;
    margin-bottom: 6px;
}

.skill-gap-page .form-group select {
    width: 100%;
    height: 39px;
    border: 1px solid #dce4ed;
    border-radius: 7px;
    padding: 0 10px;
    color: #334155;
    background: #fff;
    font-size: 13px;
}

.skill-gap-page .summary-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.skill-gap-page .summary-card {
    padding: 18px;
    position: relative;
    overflow: hidden;
}

.skill-gap-page .summary-label {
    color: #718096;
    font-size: 12px;
    font-weight: 600;
}

.skill-gap-page .summary-number {
    color: #123e68;
    font-size: 28px;
    font-weight: 800;
    margin-top: 8px;
    line-height: 1.2;
}

.skill-gap-page .summary-description {
    color: #8794a5;
    font-size: 11px;
    margin-top: 6px;
}

.skill-gap-page .summary-icon {
    position: absolute;
    right: 17px;
    top: 17px;
    width: 39px;
    height: 39px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
}

.skill-gap-page .icon-blue {
    background: #e8f2fc;
}

.skill-gap-page .icon-orange {
    background: #fff2df;
}

.skill-gap-page .icon-green {
    background: #e6f7ee;
}

.skill-gap-page .table-card {
    overflow: hidden;
}

.skill-gap-page .table-heading {
    padding: 18px 20px;
    border-bottom: 1px solid #edf1f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.skill-gap-page .table-heading h3 {
    margin: 0;
    color: #123e68;
    font-size: 15px;
    font-weight: 750;
}

.skill-gap-page .table-heading p {
    margin: 5px 0 0;
    color: #8794a5;
    font-size: 11px;
}

.skill-gap-page table {
    width: 100%;
    border-collapse: collapse;
    min-width: 850px;
}

.skill-gap-page thead th {
    background: #f4f7fb;
    color: #52657b;
    font-size: 11px;
    font-weight: 750;
    text-transform: uppercase;
    letter-spacing: .3px;
    padding: 13px 12px;
    text-align: left;
    white-space: nowrap;
}

.skill-gap-page tbody td {
    padding: 13px 12px;
    border-bottom: 1px solid #edf1f5;
    font-size: 12px;
    color: #405168;
    vertical-align: middle;
}

.skill-gap-page tbody tr:hover {
    background: #f8fbff;
}

.skill-gap-page .employee-name {
    color: #123e68;
    font-weight: 700;
    font-size: 12px;
}

.skill-gap-page .employee-no {
    color: #8794a5;
    font-size: 10px;
    margin-top: 4px;
}

.skill-gap-page .level-value {
    font-weight: 750;
    color: #334e68;
    white-space: nowrap;
}

.skill-gap-page .gap-badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 750;
    white-space: nowrap;
}

.skill-gap-page .gap-high {
    background: #fee8e7;
    color: #c0392b;
}

.skill-gap-page .gap-medium {
    background: #fff0d9;
    color: #b66a00;
}

.skill-gap-page .gap-low {
    background: #e7f2ff;
    color: #1769aa;
}

.skill-gap-page .recommendation {
    font-size: 11px;
    font-weight: 700;
}

.skill-gap-page .recommendation-training {
    color: #c0392b;
}

.skill-gap-page .recommendation-coaching {
    color: #b66a00;
}

.skill-gap-page .period-label {
    display: inline-block;
    background: #edf3f9;
    color: #315d83;
    border-radius: 5px;
    padding: 4px 7px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

.skill-gap-page .empty-state {
    text-align: center;
    padding: 45px 15px;
    color: #718096;
}

.skill-gap-page .empty-state .empty-icon {
    font-size: 32px;
    margin-bottom: 10px;
}

.skill-gap-page .empty-state strong {
    display: block;
    color: #31516f;
    font-size: 14px;
}

.skill-gap-page .pagination {
    padding: 15px 18px;
}

@media(max-width: 900px) {
    .skill-gap-page .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .skill-gap-page .summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media(max-width: 600px) {
    .skill-gap-page .filter-grid,
    .skill-gap-page .summary-grid {
        grid-template-columns: 1fr;
    }
}

@media print {
    @page {
        size: A4 landscape;
        margin: 8mm;
    }

    body {
        background: #fff !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .no-print,
    .pagination,
    .sidebar,
    .navbar,
    .topbar {
        display: none !important;
    }

    .skill-gap-page .page-head {
        margin-bottom: 12px !important;
    }

    .skill-gap-page h1 {
        font-size: 20px !important;
    }

    .skill-gap-page .summary-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 8px !important;
    }

    .skill-gap-page .summary-card {
        padding: 10px !important;
        box-shadow: none !important;
    }

    .skill-gap-page .summary-number {
        font-size: 21px !important;
    }

    .skill-gap-page .filter-card {
        display: none !important;
    }

    .skill-gap-page .table-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

    .skill-gap-page .table-wrap {
        overflow: visible !important;
    }

    .skill-gap-page table {
        min-width: 0 !important;
        width: 100% !important;
        font-size: 9px !important;
    }

    .skill-gap-page thead {
        display: table-header-group !important;
    }

    .skill-gap-page tr {
        break-inside: avoid !important;
        page-break-inside: avoid !important;
    }

    .skill-gap-page th,
    .skill-gap-page td {
        padding: 6px !important;
        font-size: 9px !important;
    }
}
</style>

@php
    $totalGap = $totalGap ?? $assessments->total();
    $averageGap = $averageGap ?? 0;
@endphp

<div class="skill-gap-page">

    {{-- HEADER --}}
    <div class="page-head">
        <div>
            <div class="eyebrow">Analisis Kompetensi</div>
            <h1>Skill Gap Analysis</h1>
            <div class="muted">
                Identifikasi kesenjangan kompetensi karyawan terhadap target level skill.
            </div>
        </div>

        <button class="btn no-print" onclick="window.print()">
            ⎙ Cetak Laporan
        </button>
    </div>

    {{-- FILTER --}}
    <div class="filter-card no-print">

        <div class="filter-title">
            <span>☷</span> Filter Laporan
        </div>

        <form method="GET" action="{{ route('reports.skill-gap') }}">

            <div class="filter-grid">

                <div class="form-group">
                    <label>Tahun Assessment</label>
                    <select name="year">
                        <option value="">Semua Tahun</option>
                        @foreach($filterOptions['years'] as $year)
                            <option value="{{ $year }}"
                                {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Periode Kuartal</label>
                    <select name="quarter">
                        <option value="">Semua Kuartal</option>
                        @foreach([1 => 'Q1', 2 => 'Q2', 3 => 'Q3', 4 => 'Q4'] as $number => $label)
                            <option value="{{ $number }}"
                                {{ request('quarter') == $number ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Departemen</label>
                    <select name="department">
                        <option value="">Semua Departemen</option>
                        @foreach($filterOptions['departments'] as $department)
                            <option value="{{ $department }}"
                                {{ request('department') == $department ? 'selected' : '' }}>
                                {{ $department }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn">
                    🔍 Terapkan
                </button>

                <a href="{{ route('reports.skill-gap') }}" class="btn btn-light">
                    ↻ Reset
                </a>

            </div>
        </form>
    </div>

    {{-- SUMMARY --}}
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-icon icon-orange">⚠️</div>
            <div class="summary-label">Total Skill Gap</div>
            <div class="summary-number">
                {{ number_format($totalGap) }}
            </div>
            <div class="summary-description">
                Kompetensi yang belum mencapai target
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon icon-blue">📊</div>
            <div class="summary-label">Rata-rata Kesenjangan</div>
            <div class="summary-number">
                {{ number_format((float) $averageGap, 1) }}
            </div>
            <div class="summary-description">
                Rata-rata selisih level aktual dengan target
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon icon-green">🎯</div>
            <div class="summary-label">Data Ditampilkan</div>
            <div class="summary-number">
                {{ number_format($assessments->total()) }}
            </div>
            <div class="summary-description">
                Data skill gap sesuai filter
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-card">

        <div class="table-heading">
            <div>
                <h3>Detail Kesenjangan Kompetensi</h3>
                <p>
                    Daftar karyawan yang memiliki level aktual di bawah target kompetensi.
                </p>
            </div>

            <div class="muted">
                Total {{ number_format($assessments->total()) }} data
            </div>
        </div>

        <div class="table-wrap">

            <table>
                <thead>
                    <tr>
                        <th width="45">No.</th>
                        <th>Karyawan</th>
                        <th>Departemen</th>
                        <th>Periode</th>
                        <th>Kompetensi / Skill</th>
                        <th>Level Aktual</th>
                        <th>Target</th>
                        <th>Gap</th>
                        <th>Rekomendasi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($assessments as $index => $a)

                        @php
                            $gap = (int) $a->target_level - (int) $a->assessed_level;

                            $gapClass = $gap >= 3
                                ? 'gap-high'
                                : ($gap == 2 ? 'gap-medium' : 'gap-low');

                            $recommendation = $gap >= 2
                                ? 'Training Prioritas'
                                : 'Coaching / OJT';
                        @endphp

                        <tr>

                            <td>
                                {{ $assessments->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="employee-name">
                                    {{ $a->employee->name ?? '-' }}
                                </div>
                                <div class="employee-no">
                                    NIK: {{ $a->employee->employee_no ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $a->employee->department ?? '-' }}
                            </td>

                            <td>
                                <span class="period-label">
                                    {{ $a->period_label ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <strong>
                                    {{ $a->skill->name ?? '-' }}
                                </strong>
                            </td>

                            <td>
                                <span class="level-value">
                                    {{ $a->assessed_level }}/5
                                </span>
                            </td>

                            <td>
                                <span class="level-value">
                                    {{ $a->target_level }}/5
                                </span>
                            </td>

                            <td>
                                <span class="gap-badge {{ $gapClass }}">
                                    -{{ $gap }} Level
                                </span>
                            </td>

                            <td>
                                @if($gap >= 2)
                                    <span class="recommendation recommendation-training">
                                        ● Training Prioritas
                                    </span>
                                @else
                                    <span class="recommendation recommendation-coaching">
                                        ● Coaching / OJT
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon">✓</div>
                                    <strong>Tidak Ada Skill Gap</strong>
                                    Tidak ditemukan kompetensi yang berada di bawah target.
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="pagination no-print">
            {{ $assessments->links() }}
        </div>

    </div>

</div>

@endsection