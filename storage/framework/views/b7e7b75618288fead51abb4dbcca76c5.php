<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $levelColors = [
        'Pemula' => '#e05260',
        'Dasar' => '#f59e0b',
        'Menengah' => '#3886c7',
        'Mahir' => '#16a085',
        'Ahli' => '#7356bf',
    ];

    $maxLevel = max(1, (int) max($levels ?: [0]));

    $chartItems = $skills->take(8);

    $gapPercent = $assessmentCount > 0
        ? round(($gapCount / $assessmentCount) * 100, 1)
        : 0;

    $achievementPercent = max(0, 100 - $gapPercent);

    /*
    |--------------------------------------------------------------------------
    | DATA GRAFIK ASSESSMENT PER KUARTAL
    |--------------------------------------------------------------------------
    */

    $quarterlyRows = \App\Models\Assessment::query()
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
?>

<style>
.dashboard-page {
    color: #243247;
}

.dashboard-page .page-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 23px;
}

.dashboard-page .eyebrow {
    color: #e58a24;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.dashboard-page h1 {
    color: #123e68;
    font-size: 25px;
    font-weight: 800;
    margin: 0;
}

.dashboard-page .muted {
    color: #8491a2;
    font-size: 12px;
    margin-top: 5px;
}

.dashboard-page .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    background: #1769aa;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}

.dashboard-page .btn:hover {
    background: #123e68;
}

.dashboard-page .btn.light {
    background: #edf4fa;
    color: #1769aa;
}

.dashboard-page .dashboard-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 15px;
    margin-bottom: 19px;
}

.dashboard-page .stat-card,
.dashboard-page .panel {
    background: #fff;
    border: 1px solid #e8edf3;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(25, 55, 90, .04);
}

.dashboard-page .stat-card {
    padding: 18px;
    position: relative;
    overflow: hidden;
}

.dashboard-page .stat-card:after {
    content: "";
    position: absolute;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    right: -22px;
    bottom: -27px;
    background: var(--soft);
}

.dashboard-page .stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #728197;
    font-size: 12px;
    font-weight: 650;
}

.dashboard-page .stat-icon {
    width: 37px;
    height: 37px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    background: var(--soft);
    color: var(--accent);
}

.dashboard-page .stat-number {
    font-size: 29px;
    font-weight: 800;
    color: #123e68;
    margin-top: 12px;
    line-height: 1.2;
}

.dashboard-page .stat-foot {
    color: #8794a5;
    font-size: 11px;
    margin-top: 7px;
}

.dashboard-page .positive {
    color: #16a085;
}

.dashboard-page .dashboard-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 17px;
    margin-bottom: 18px;
}

.dashboard-page .panel {
    padding: 19px;
    min-width: 0;
}

.dashboard-page .panel-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
}

.dashboard-page .panel-heading h2 {
    font-size: 15px;
    color: #123e68;
    font-weight: 800;
    margin: 0;
}

.dashboard-page .panel-heading p {
    font-size: 11px;
    color: #8a96a5;
    margin: 5px 0 0;
}

.dashboard-page .badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    background: #e8f2fc;
    color: #1769aa;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.dashboard-page .badge.warning {
    background: #fff0d9;
    color: #b66a00;
}

.dashboard-page .badge.success {
    background: #e5f7ee;
    color: #16835c;
}

.dashboard-page .badge.danger {
    background: #fee9e8;
    color: #c0392b;
}

/* PERFORMANCE */
.dashboard-page .performance-summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 13px 15px;
    background: #f5f8fc;
    border-radius: 9px;
    margin-bottom: 20px;
}

.dashboard-page .performance-summary strong {
    color: #123e68;
    font-size: 23px;
    font-weight: 800;
}

.dashboard-page .performance-summary span {
    color: #8290a2;
    font-size: 11px;
}

.dashboard-page .chart-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.dashboard-page .chart-row {
    display: grid;
    grid-template-columns: minmax(90px, 125px) 1fr 42px;
    align-items: center;
    gap: 12px;
}

.dashboard-page .chart-name {
    font-size: 11px;
    color: #52657b;
    font-weight: 650;
}

.dashboard-page .chart-track {
    height: 10px;
    background: #edf1f5;
    border-radius: 20px;
    overflow: hidden;
}

.dashboard-page .chart-fill {
    height: 100%;
    border-radius: 20px;
    background: #1769aa;
}

.dashboard-page .chart-value {
    font-size: 11px;
    font-weight: 750;
    text-align: right;
    color: #31516f;
}

.dashboard-page .legend {
    display: flex;
    gap: 17px;
    flex-wrap: wrap;
    margin-top: 19px;
    font-size: 10px;
    color: #8290a2;
}

.dashboard-page .legend span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.dashboard-page .dot {
    width: 8px;
    height: 8px;
    display: inline-block;
    border-radius: 50%;
}

/* DISTRIBUTION */
.dashboard-page .level-list {
    display: flex;
    flex-direction: column;
    gap: 19px;
}

.dashboard-page .progress-row {
    margin-bottom: 14px;
}

.dashboard-page .progress-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 7px;
    font-size: 11px;
    color: #52657b;
}

.dashboard-page .progress-meta b {
    color: #123e68;
}

.dashboard-page .progress {
    height: 8px;
    border-radius: 20px;
    background: #edf1f5;
    overflow: hidden;
}

.dashboard-page .progress span {
    height: 100%;
    display: block;
    border-radius: 20px;
    background: #1769aa;
}

/* ACHIEVEMENT */
.dashboard-page .achievement-box {
    padding: 17px;
    background: #f7f9fc;
    border-radius: 10px;
    margin-top: 20px;
}

.dashboard-page .achievement-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.dashboard-page .achievement-top span {
    font-size: 11px;
    color: #607187;
}

.dashboard-page .achievement-top strong {
    font-size: 21px;
    color: #16835c;
    font-weight: 800;
}

.dashboard-page .achievement-bar {
    height: 11px;
    display: flex;
    overflow: hidden;
    border-radius: 20px;
    background: #e7edf2;
}

.dashboard-page .achievement-done {
    background: #16a085;
    height: 100%;
}

.dashboard-page .achievement-gap {
    background: #e9a23b;
    height: 100%;
}

/* QUARTERLY LINE CHART */
.dashboard-page .quarterly-chart {
    position: relative;
    width: 100%;
    height: 300px;
}

.dashboard-page .quarterly-chart canvas {
    width: 100% !important;
    height: 100% !important;
}

.dashboard-page .chart-empty {
    padding: 45px 10px;
    text-align: center;
    color: #8794a5;
    font-size: 12px;
}

/* TABLE */
.dashboard-page .table-wrap {
    overflow-x: auto;
}

.dashboard-page table {
    width: 100%;
    border-collapse: collapse;
    min-width: 650px;
}

.dashboard-page thead th {
    background: #f5f8fc;
    color: #718096;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .3px;
    padding: 12px 10px;
    text-align: left;
    white-space: nowrap;
}

.dashboard-page tbody td {
    padding: 12px 10px;
    border-bottom: 1px solid #edf1f5;
    color: #43546a;
    font-size: 11px;
}

.dashboard-page tbody tr:hover {
    background: #f8fbff;
}

.dashboard-page .person {
    display: flex;
    align-items: center;
    gap: 9px;
}

.dashboard-page .mini-avatar {
    width: 31px;
    height: 31px;
    flex-shrink: 0;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e8f2fc;
    color: #1769aa;
    font-weight: 800;
    font-size: 12px;
}

.dashboard-page .person b {
    display: block;
    color: #23415e;
    font-size: 11px;
}

.dashboard-page .person small {
    display: block;
    color: #8a96a5;
    font-size: 9px;
    margin-top: 3px;
}

.dashboard-page .skill-item {
    margin-bottom: 17px;
}

.dashboard-page .empty {
    padding: 25px 10px;
    text-align: center;
    color: #8794a5;
    font-size: 12px;
}

.dashboard-page .skill-percent {
    color: #1769aa;
    font-weight: 800;
}

@media(max-width: 1050px) {
    .dashboard-page .dashboard-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .dashboard-page .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 600px) {
    .dashboard-page .dashboard-stats {
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .dashboard-page .stat-card {
        padding: 13px;
    }

    .dashboard-page .stat-number {
        font-size: 23px;
    }

    .dashboard-page .panel {
        padding: 13px;
    }

    .dashboard-page .chart-row {
        grid-template-columns: 85px 1fr 35px;
        gap: 7px;
    }

    .dashboard-page .quarterly-chart {
        height: 240px;
    }
}
</style>

<div class="dashboard-page">

    
    <div class="page-head">
        <div>
            <div class="eyebrow">PRATAMA · HUMAN RESOURCES DEVELOPMENT</div>
            <h1>Dashboard Skill Matrix</h1>
            <div class="muted">
                Ringkasan kompetensi, pencapaian target, dan pengembangan karyawan.
            </div>
        </div>

        <a class="btn no-print" href="<?php echo e(route('assessments.create')); ?>">
            ＋ Input Assessment
        </a>
    </div>

    
    <div class="dashboard-stats">

        <div class="stat-card" style="--accent:#1769aa;--soft:#e8f2fc">
            <div class="stat-top">
                Total Karyawan
                <span class="stat-icon">♙</span>
            </div>
            <div class="stat-number">
                <?php echo e(number_format($employeeCount)); ?>

            </div>
            <div class="stat-foot">
                <span class="positive">●</span> Data karyawan HRIS
            </div>
        </div>

        <div class="stat-card" style="--accent:#7356bf;--soft:#f0ebfa">
            <div class="stat-top">
                Master Skill Aktif
                <span class="stat-icon">✧</span>
            </div>
            <div class="stat-number">
                <?php echo e(number_format($skillCount)); ?>

            </div>
            <div class="stat-foot">
                Kompetensi yang dipantau
            </div>
        </div>

        <div class="stat-card" style="--accent:#16835c;--soft:#e5f7ee">
            <div class="stat-top">
                Assessment Tercatat
                <span class="stat-icon">✓</span>
            </div>
            <div class="stat-number">
                <?php echo e(number_format($assessmentCount)); ?>

            </div>
            <div class="stat-foot">
                Data penilaian tersimpan
            </div>
        </div>

        <div class="stat-card" style="--accent:#d17b18;--soft:#fff2df">
            <div class="stat-top">
                Skill Gap
                <span class="stat-icon">↗</span>
            </div>
            <div class="stat-number">
                <?php echo e(number_format($gapCount)); ?>

            </div>
            <div class="stat-foot">
                Kompetensi perlu dikembangkan
            </div>
        </div>

    </div>

    
    <section class="panel" style="margin-bottom:18px">

        <div class="panel-heading">
            <div>
                <h2>Trend Assessment Per Kuartal</h2>
                <p>
                    Perkembangan jumlah input assessment berdasarkan periode Q1–Q4.
                </p>
            </div>

            <span class="badge">Line Chart</span>
        </div>

        <?php if($quarterlyRows->isNotEmpty()): ?>

            <div class="quarterly-chart">
                <canvas id="quarterlyAssessmentChart"></canvas>
            </div>

        <?php else: ?>

            <div class="chart-empty">
                Belum ada data assessment berdasarkan periode kuartal.
            </div>

        <?php endif; ?>

    </section>

    
    <div class="dashboard-grid">

        <section class="panel">

            <div class="panel-heading">
                <div>
                    <h2>Overall Performance Score</h2>
                    <p>Rata-rata pencapaian level kompetensi berdasarkan assessment.</p>
                </div>
                <span class="badge">Performance</span>
            </div>

            <div class="performance-summary">
                <div>
                    <span>Rata-rata kompetensi</span>
                    <div>
                        <strong><?php echo e($average); ?>%</strong>
                    </div>
                </div>
                <span class="badge success">Level Aktual</span>
            </div>

            <div class="chart-list">

                <?php $__empty_1 = true; $__currentLoopData = $chartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <?php
                        $avg = \App\Models\Assessment::where(
                            'skill_id', $skill->id
                        )->avg('assessed_level');

                        $current = $avg
                            ? min(100, max(0, $avg / 5 * 100))
                            : 0;

                        $target = min(
                            100,
                            max(0, $skill->target_level / 5 * 100)
                        );
                    ?>

                    <div class="chart-row">
                        <div class="chart-name">
                            <?php echo e(\Illuminate\Support\Str::limit($skill->name, 18)); ?>

                        </div>

                        <div class="chart-track">
                            <div class="chart-fill"
                                style="width:<?php echo e($current); ?>%">
                            </div>
                        </div>

                        <div class="chart-value">
                            <?php echo e(round($current)); ?>%
                        </div>
                    </div>

                    <div style="margin-top:-9px;margin-left:calc(125px + 12px);margin-bottom:5px">
                        <div class="chart-track" style="height:4px">
                            <div style="height:100%;width:<?php echo e($target); ?>%;background:#34465e;border-radius:20px">
                            </div>
                        </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <div class="empty">
                        Belum ada data skill untuk ditampilkan.
                    </div>

                <?php endif; ?>

            </div>

            <div class="legend">
                <span>
                    <i class="dot" style="background:#1769aa"></i>
                    Level saat ini
                </span>
                <span>
                    <i class="dot" style="background:#34465e"></i>
                    Target level
                </span>
            </div>

        </section>

        <section class="panel">

            <div class="panel-heading">
                <div>
                    <h2>Distribusi Level Skill</h2>
                    <p>Jumlah assessment berdasarkan tingkat kompetensi.</p>
                </div>
                <span class="badge">Level 1–5</span>
            </div>

            <div class="level-list">

                <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="progress-row">

                        <div class="progress-meta">
                            <span><?php echo e($label); ?></span>
                            <b><?php echo e(number_format($count)); ?></b>
                        </div>

                        <div class="progress">
                            <span style="
                                width:<?php echo e($count / $maxLevel * 100); ?>%;
                                background:<?php echo e($levelColors[$label] ?? '#1769aa'); ?>">
                            </span>
                        </div>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

            <div class="achievement-box">

                <div class="achievement-top">
                    <span>Target kompetensi tercapai</span>
                    <strong><?php echo e($achievementPercent); ?>%</strong>
                </div>

                <div class="achievement-bar">
                    <div class="achievement-done"
                        style="width:<?php echo e($achievementPercent); ?>%">
                    </div>
                    <div class="achievement-gap"
                        style="width:<?php echo e($gapPercent); ?>%">
                    </div>
                </div>

                <div class="legend">
                    <span>
                        <i class="dot" style="background:#16a085"></i>
                        Mencapai target
                    </span>
                    <span>
                        <i class="dot" style="background:#e9a23b"></i>
                        Belum mencapai target
                    </span>
                </div>

            </div>

        </section>

    </div>

    
    <div class="dashboard-grid">

        <section class="panel">

            <div class="panel-heading">
                <div>
                    <h2>Assessment Terbaru</h2>
                    <p>Penilaian kompetensi yang terakhir tercatat.</p>
                </div>

                <a class="btn light no-print"
                    href="<?php echo e(route('assessments.index')); ?>">
                    Lihat Semua →
                </a>
            </div>

            <div class="table-wrap">

                <table>
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Skill</th>
                            <th>Aktual</th>
                            <th>Target</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                <td>
                                    <div class="person">

                                        <span class="mini-avatar">
                                            <?php echo e(strtoupper(substr($item->employee->name ?? '?', 0, 1))); ?>

                                        </span>

                                        <span>
                                            <b>
                                                <?php echo e($item->employee->name ?? 'Karyawan dihapus'); ?>

                                            </b>
                                            <small>
                                                <?php echo e($item->employee->employee_no ?? '-'); ?>

                                            </small>
                                        </span>

                                    </div>
                                </td>

                                <td>
                                    <?php echo e($item->skill->name ?? '-'); ?>

                                </td>

                                <td>
                                    <b><?php echo e($item->assessed_level); ?>/5</b>
                                </td>

                                <td>
                                    <?php echo e($item->target_level); ?>/5
                                </td>

                                <td>
                                    <?php if($item->assessed_level >= $item->target_level): ?>
                                        <span class="badge success">Kompeten</span>
                                    <?php else: ?>
                                        <span class="badge warning">Perlu Training</span>
                                    <?php endif; ?>
                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>
                                <td colspan="5" class="empty">
                                    Belum ada assessment.
                                    Tambahkan penilaian pertama Anda.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>
                </table>

            </div>

        </section>

        <section class="panel">

            <div class="panel-heading">
                <div>
                    <h2>Skill Matrix Overview</h2>
                    <p>Ringkasan pencapaian setiap kompetensi.</p>
                </div>

                <a href="<?php echo e(route('skills.index')); ?>"
                    class="muted no-print">
                    Semua →
                </a>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <?php
                    $avg = \App\Models\Assessment::where(
                        'skill_id', $skill->id
                    )->avg('assessed_level');

                    $percent = $avg
                        ? min(100, max(0, $avg / 5 * 100))
                        : 0;
                ?>

                <div class="skill-item">

                    <div class="progress-meta">
                        <span><?php echo e($skill->name); ?></span>
                        <b class="skill-percent">
                            <?php echo e(round($percent)); ?>%
                        </b>
                    </div>

                    <div class="progress">
                        <span style="width:<?php echo e($percent); ?>%"></span>
                    </div>

                    <div class="stat-foot">
                        Target level <?php echo e($skill->target_level); ?>/5
                        · <?php echo e($skill->assessments_count); ?> assessment
                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="empty">
                    Belum ada skill yang terdaftar.
                </div>

            <?php endif; ?>

        </section>

    </div>

</div>


<?php if($quarterlyRows->isNotEmpty()): ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('quarterlyAssessmentChart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    const labels = <?php echo json_encode($quarterlyLabels, 15, 512) ?>;
    const totals = <?php echo json_encode($quarterlyTotals, 15, 512) ?>;

    new Chart(canvas, {
        type: 'line',

        data: {
            labels: labels,

            datasets: [{
                label: 'Jumlah Assessment',
                data: totals,

                borderColor: '#1769aa',
                backgroundColor: 'rgba(23, 105, 170, 0.12)',

                borderWidth: 3,
                tension: 0.35,
                fill: true,

                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#1769aa',
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                intersect: false,
                mode: 'index'
            },

            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },

                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' Assessment';
                        }
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Assessment'
                    },
                    grid: {
                        color: '#edf1f5'
                    }
                },

                x: {
                    title: {
                        display: true,
                        text: 'Periode Kuartal'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

});
</script>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\skill-matrix\resources\views/dashboard.blade.php ENDPATH**/ ?>