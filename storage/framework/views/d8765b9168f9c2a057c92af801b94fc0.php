<?php $__env->startSection('title', 'Laporan Assessment'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $achievementPercent = $assessmentCount > 0
        ? ($achievedCount / $assessmentCount) * 100
        : 0;

    $gapPercent = $assessmentCount > 0
        ? ($gapCount / $assessmentCount) * 100
        : 0;

    $groupedReportAssessments = $assessments->getCollection()
        ->groupBy('employee_id');
?>

<style>
    /* =========================================
       FILTER LAPORAN
    ========================================= */

    .report-filter {
        display: grid;
        grid-template-columns: repeat(4, minmax(150px, 1fr));
        gap: 12px;
        align-items: end;
    }

    .report-filter label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
    }

    .report-filter select {
        width: 100%;
        padding: 10px;
        border: 1px solid #dce3ed;
        border-radius: 8px;
        background: #fff;
    }

    /* =========================================
       RINGKASAN
    ========================================= */

    .report-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .report-card {
        padding: 20px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #e8edf4;
    }

    .report-card .stat-top {
        color: #718096;
        font-size: 13px;
    }

    .report-card .stat-number {
        font-size: 27px;
        font-weight: 750;
        margin-top: 8px;
        color: #173b63;
    }

    .report-progress {
        height: 9px;
        background: #edf1f6;
        border-radius: 20px;
        overflow: hidden;
        margin-top: 10px;
    }

    .report-progress-fill {
        height: 100%;
        border-radius: 20px;
        background: #26966b;
    }

    /* =========================================
       GRAFIK
    ========================================= */

    .report-charts {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 20px;
    }

    .chart-card {
        padding: 22px;
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 12px;
        min-width: 0;
    }

    .chart-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #243247;
    }

    /* =========================================
       PENCAPAIAN TARGET KOMPETENSI
    ========================================= */

    .achievement-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 25px 15px 20px;
    }

    .achievement-item {
        flex: 1;
    }

    .achievement-percent {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .achievement-percent.achieved {
        color: #16845c;
    }

    .achievement-percent.not-achieved {
        color: #d97724;
    }

    .achievement-label {
        font-size: 15px;
        color: #526174;
        font-weight: 500;
    }

    .achievement-progress {
        display: flex;
        width: 100%;
        height: 16px;
        gap: 8px;
        margin: 5px 0 15px;
        overflow: hidden;
    }

    .progress-achieved {
        height: 100%;
        background: #16845c;
        border-radius: 20px;
    }

    .progress-gap {
        height: 100%;
        background: #d97724;
        border-radius: 20px;
    }

    .illustration-note {
        font-size: 12px;
        color: #8993a1;
        margin-top: 12px;
    }

    /* =========================================
       TABEL DETAIL
    ========================================= */

    .report-table-title {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .period-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #eaf2fb;
        color: #205b91;
        font-size: 12px;
        font-weight: 700;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media(max-width: 900px) {
        .report-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .report-filter {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 600px) {
        .report-stats,
        .report-charts,
        .report-filter {
            grid-template-columns: 1fr;
        }

        .achievement-percent {
            font-size: 34px;
        }
    }

    
/* =========================================
   CETAK / SIMPAN PDF - MAKSIMAL 2 HALAMAN
========================================= */

    @media print {

        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        html,
        body {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Hilangkan elemen yang tidak dicetak */
        .no-print,
        .pagination {
            display: none !important;
        }

        /* Hilangkan jarak layout utama */
        .page-head {
            margin-top: 0 !important;
            margin-bottom: 8px !important;
        }

        .page-head h1 {
            font-size: 20px !important;
            margin: 0 !important;
        }

        .page-head .muted {
            font-size: 10px !important;
        }

        /* Ringkasan */
        .report-stats {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 6px !important;
            margin: 8px 0 !important;
        }

        .report-card {
            padding: 7px !important;
            border-radius: 6px !important;
        }

        .report-card .stat-top {
            font-size: 10px !important;
        }

        .report-card .stat-number {
            font-size: 17px !important;
            margin-top: 3px !important;
        }

        .report-progress {
            height: 6px !important;
            margin-top: 5px !important;
        }

        /* Grafik halaman pertama */
        .report-charts {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 7px !important;
            margin: 0 !important;
        }

        .chart-card {
            padding: 8px !important;
            border-radius: 6px !important;
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        .chart-title {
            font-size: 11px !important;
            margin-bottom: 5px !important;
        }

        /* Paksa grafik pencapaian selebar halaman */
        .report-charts > .chart-card:last-child {
            grid-column: 1 / -1 !important;
        }

        /* Pendekkan grafik Chart.js */
        #quarterLineChart,
        #levelColumnChart {
            max-height: 150px !important;
        }

        .report-charts .chart-card > div[style*="height"] {
            height: 145px !important;
        }

        /* Pencapaian target */
        .achievement-summary {
            padding: 5px 10px !important;
            gap: 10px !important;
        }

        .achievement-percent {
            font-size: 24px !important;
            margin-bottom: 2px !important;
        }

        .achievement-label {
            font-size: 10px !important;
        }

        .achievement-progress {
            height: 9px !important;
            margin: 3px 0 5px !important;
        }

        .illustration-note {
            font-size: 9px !important;
            margin-top: 3px !important;
        }

        /* Warna tetap tercetak */
        .report-card,
        .chart-card,
        .card,
        .period-badge,
        .badge,
        .achievement-progress,
        .progress-achieved,
        .progress-gap,
        .report-progress-fill {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* =====================================
        TABEL DIMULAI DI HALAMAN KEDUA
        ===================================== */

        .report-detail-page {
            display: block !important;
            break-before: page !important;
            page-break-before: always !important;
            margin-top: 0 !important;
            padding: 8px !important;
            border: none !important;
            box-shadow: none !important;
        }

        .report-table-title {
            font-size: 14px !important;
            margin-bottom: 8px !important;
            break-after: avoid !important;
            page-break-after: avoid !important;
        }

        .report-detail-page .muted {
            font-size: 10px !important;
            margin-bottom: 7px !important;
        }

        .report-detail-page .table-wrap {
            overflow: visible !important;
            width: 100% !important;
        }

        .report-detail-page table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 8px !important;
            page-break-inside: auto !important;
        }

        .report-detail-page thead {
            display: table-header-group !important;
        }

        .report-detail-page tr {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        .report-detail-page th,
        .report-detail-page td {
            padding: 4px !important;
            font-size: 8px !important;
        }

    }
</style>




<div class="page-head">
    <div>
        <div class="eyebrow">Laporan & Analitik</div>

        <h1>Laporan Assessment</h1>

        <div class="muted">
            Ringkasan kompetensi, pencapaian target,
            dan perkembangan assessment per kuartal.
        </div>
    </div>

    <button class="btn no-print" onclick="window.print()">
        ⎙ Cetak / Simpan PDF
    </button>
</div>




<div class="card no-print" style="margin-bottom:20px;">

    <form method="GET" action="<?php echo e(route('reports.index')); ?>">

        <div class="report-filter">

            <div>
                <label>Tahun</label>

                <select name="year">
                    <option value="">Semua Tahun</option>

                    <?php $__currentLoopData = $filterOptions['years']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($year); ?>"
                            <?php echo e(request('year') == $year ? 'selected' : ''); ?>>
                            <?php echo e($year); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label>Kuartal</label>

                <select name="quarter">
                    <option value="">Semua Kuartal</option>

                    <option value="1" <?php echo e(request('quarter') == '1' ? 'selected' : ''); ?>>
                        Q1 - Januari - Maret
                    </option>

                    <option value="2" <?php echo e(request('quarter') == '2' ? 'selected' : ''); ?>>
                        Q2 - April - Juni
                    </option>

                    <option value="3" <?php echo e(request('quarter') == '3' ? 'selected' : ''); ?>>
                        Q3 - Juli - September
                    </option>

                    <option value="4" <?php echo e(request('quarter') == '4' ? 'selected' : ''); ?>>
                        Q4 - Oktober - Desember
                    </option>
                </select>
            </div>

            <div>
                <label>Departemen</label>

                <select name="department">
                    <option value="">Semua Departemen</option>

                    <?php $__currentLoopData = $filterOptions['departments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($department); ?>"
                            <?php echo e(request('department') == $department ? 'selected' : ''); ?>>
                            <?php echo e($department); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn">
                    Tampilkan
                </button>

                <a href="<?php echo e(route('reports.index')); ?>" class="btn">
                    Reset
                </a>
            </div>

        </div>
    </form>
</div>




<div class="report-stats">

    <div class="report-card">
        <div class="stat-top">Total Karyawan HRIS</div>
        <div class="stat-number">
            <?php echo e(number_format($employeeCount)); ?>

        </div>
    </div>

    <div class="report-card">
        <div class="stat-top">Total Skill</div>
        <div class="stat-number">
            <?php echo e(number_format($skillCount)); ?>

        </div>
    </div>

    <div class="report-card">
        <div class="stat-top">Total Assessment</div>
        <div class="stat-number">
            <?php echo e(number_format($assessmentCount)); ?>

        </div>
        <div class="muted" style="font-size:12px;">
            Jumlah penilaian skill
        </div>
    </div>

    <div class="report-card">
        <div class="stat-top">Pencapaian Target</div>
        <div class="stat-number">
            <?php echo e(number_format($achievementPercent, 1)); ?>%
        </div>

        <div class="report-progress">
            <div class="report-progress-fill"
                 style="width:<?php echo e($achievementPercent); ?>%">
            </div>
        </div>
    </div>

</div>




<div class="report-charts">

    
    <div class="chart-card">

        <div class="chart-title">
            Tren Assessment per Kuartal
        </div>

        <div style="height:300px;position:relative;">
            <canvas id="quarterLineChart"></canvas>
        </div>

    </div>


    
    <div class="chart-card">

        <div class="chart-title">
            Distribusi Level Kompetensi
        </div>

        <div style="height:300px;position:relative;">
            <canvas id="levelColumnChart"></canvas>
        </div>

    </div>


    
    <div class="chart-card" style="grid-column:1/-1;">

        <div class="chart-title">
            Tingkat Pencapaian Target Kompetensi
        </div>

        <div class="achievement-summary">

            <div class="achievement-item">

                <div class="achievement-percent achieved">
                    <?php echo e(number_format($achievementPercent, 0)); ?>%
                </div>

                <div class="achievement-label">
                    Target tercapai
                </div>

            </div>

            <div class="achievement-item">

                <div class="achievement-percent not-achieved">
                    <?php echo e(number_format($gapPercent, 0)); ?>%
                </div>

                <div class="achievement-label">
                    Belum tercapai
                </div>

            </div>

        </div>

        
        <div class="achievement-progress">

            <?php if($assessmentCount > 0): ?>

                <div class="progress-achieved"
                     style="width:<?php echo e($achievementPercent); ?>%">
                </div>

                <div class="progress-gap"
                     style="width:<?php echo e($gapPercent); ?>%">
                </div>

            <?php endif; ?>

        </div>

        <div class="illustration-note">
            Persentase berdasarkan data penilaian sesuai filter yang dipilih.
        </div>

    </div>

</div>




<div class="card report-detail-page">

    <div class="report-table-title">
        Detail Penilaian Kompetensi
    </div>

    <div class="muted" style="font-size:13px;margin-bottom:15px;">
        Total <?php echo e(number_format($assessmentCount)); ?> penilaian skill.
    </div>

    <div class="table-wrap">

        <table>

            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Departemen</th>
                    <th>Periode</th>
                    <th>Tanggal</th>
                    <th>Skill</th>
                    <th>Aktual</th>
                    <th>Target</th>
                    <th>Gap</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $groupedReportAssessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employeeGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php $__currentLoopData = $employeeGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <?php if($index === 0): ?>

                                <td rowspan="<?php echo e($employeeGroup->count()); ?>">
                                    <strong>
                                        <?php echo e($a->employee->employee_no ?? '-'); ?>

                                    </strong>
                                </td>

                                <td rowspan="<?php echo e($employeeGroup->count()); ?>">
                                    <strong>
                                        <?php echo e($a->employee->name ?? '-'); ?>

                                    </strong>
                                </td>

                                <td rowspan="<?php echo e($employeeGroup->count()); ?>">
                                    <?php echo e($a->employee->department ?? '-'); ?>

                                </td>

                            <?php endif; ?>

                            <td>
                                <span class="period-badge">
                                    <?php echo e($a->period_label); ?>

                                </span>
                            </td>

                            <td>
                                <?php echo e($a->assessed_at?->format('d/m/Y') ?? '-'); ?>

                            </td>

                            <td>
                                <?php echo e($a->skill->name ?? '-'); ?>

                            </td>

                            <td><?php echo e($a->assessed_level); ?>/5</td>

                            <td><?php echo e($a->target_level); ?>/5</td>

                            <td><?php echo e($a->gap); ?></td>

                            <td>

                                <?php if($a->assessed_level >= $a->target_level): ?>

                                    <span class="badge">
                                        Tercapai
                                    </span>

                                <?php else: ?>

                                    <span class="badge warning">
                                        Gap
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="10" class="empty">
                            Belum ada data assessment.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <div class="pagination">
        <?php echo e($assessments->links()); ?>

    </div>

</div>




<?php $__env->startPush('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // DATA TREN ASSESSMENT PER KUARTAL
    const quarterData = <?php echo json_encode($quarterSummary, 15, 512) ?>;

    const quarterLabels = quarterData.map(item =>
        'Q' + item.period_quarter + ' - ' + item.period_year
    );

    const quarterTotals = quarterData.map(item =>
        Number(item.total)
    );


    // DATA DISTRIBUSI LEVEL KOMPETENSI
    const levelData = <?php echo json_encode($levelSummary, 15, 512) ?>;

    const levelLabels = [
        'Level 1',
        'Level 2',
        'Level 3',
        'Level 4',
        'Level 5'
    ];

    const levelTotals = [1, 2, 3, 4, 5].map(level => {

        const found = levelData.find(item =>
            Number(item.assessed_level) === level
        );

        return found ? Number(found.total) : 0;

    });


    // GRAFIK LINE
    new Chart(document.getElementById('quarterLineChart'), {

        type: 'line',

        data: {
            labels: quarterLabels,

            datasets: [{
                label: 'Jumlah Assessment',
                data: quarterTotals,
                borderColor: '#1769aa',
                backgroundColor: 'rgba(23, 105, 170, 0.18)',
                fill: true,
                tension: 0.35,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#1769aa'
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,

            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }

    });


    // GRAFIK COLUMN
    new Chart(document.getElementById('levelColumnChart'), {

        type: 'bar',

        data: {
            labels: levelLabels,

            datasets: [{
                label: 'Jumlah Penilaian',
                data: levelTotals,

                backgroundColor: [
                    '#dc6464',
                    '#e69a43',
                    '#d7b53b',
                    '#4d9acb',
                    '#26966b'
                ],

                borderRadius: 7,
                maxBarThickness: 65
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }

    });

});
</script>

<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\skill-matrix\resources\views/reports/index.blade.php ENDPATH**/ ?>