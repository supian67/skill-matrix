<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — HRM Skill Matrix</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">

    <style>
        :root {
            --navy: #1e2b3e;
            --navy-dark: #172337;
            --orange: #f36b21;
            --orange-light: #fff0e7;
            --blue: #246ca5;
            --blue2: #e8f2fc;
            --ink: #1e293b;
            --muted: #718096;
            --line: #e5eaf1;
            --bg: #f7f8fa;
            --white: #fff;
            --green: #16a085;
            --amber: #f59e0b;
            --red: #e05260;
            --sidebar-width: 245px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font: 14px/1.5 Inter, Segoe UI, Arial, sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* HEADER */
        .topbar {
            height: 65px;
            background: #fff;
            color: #26364a;
            border-bottom: 1px solid #e9edf2;
            box-shadow: 0 2px 10px #17233708;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 22px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .brand {
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .3px;
            min-width: 0;
        }

        .brand img {
            height: 42px;
            max-width: 170px;
            object-fit: contain;
        }

        .brand-text {
            white-space: nowrap;
        }

        .brand-text small {
            display: block;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: .7px;
        }

        /* TOMBOL HAMBURGER */
        .menu-toggle {
            width: 40px;
            height: 40px;
            display: none;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 9px;
            background: #fff;
            color: var(--navy);
            font-size: 23px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .menu-toggle:hover {
            background: var(--orange-light);
            color: var(--orange);
        }

        /* LAYOUT */
        .shell {
            display: flex;
            min-height: calc(100vh - 65px);
            position: relative;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            flex: 0 0 var(--sidebar-width);
            background: var(--navy);
            color: #fff;
            padding: 18px 12px;
            overflow-y: auto;
            transition: transform .25s ease;
        }

        .profile {
            text-align: center;
            padding: 8px 8px 20px;
            border-bottom: 1px solid #ffffff20;
            margin-bottom: 14px;
        }

        .avatar {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f36b21;
            color: white;
            font-size: 26px;
            font-weight: 700;
            margin: 0 auto 12px;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile strong {
            display: block;
            color: #fff;
            font-size: 13px;
        }

        .profile small {
            color: #aebbd0;
            font-size: 11px;
        }

        .nav-label {
            color: #8e9caf;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            padding: 13px 12px 6px;
        }

        .nav-link {
            display: flex;
            gap: 11px;
            align-items: center;
            padding: 11px 12px;
            border-radius: 7px;
            margin: 3px 0;
            color: #d1d9e5;
            font-weight: 600;
            font-size: 13px;
            transition: .2s;
        }

        .nav-link:hover {
            background: #ffffff12;
            color: #fff;
        }

        .nav-link.active {
            background: var(--orange);
            color: #fff;
            box-shadow: 0 4px 12px #f36b2130;
        }

        .nav-icon {
            width: 20px;
            min-width: 20px;
            text-align: center;
            font-size: 17px;
        }

        /* AREA KONTEN */
        main {
            min-width: 0;
            flex: 1;
            padding: 25px 28px 40px;
            background: var(--bg);
            overflow-x: hidden;
        }

        /* KOMPONEN UMUM */
        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .page-head h1 {
            font-size: 24px;
            margin: 0 0 4px;
        }

        .muted {
            color: var(--muted);
        }

        .eyebrow {
            font-size: 12px;
            color: var(--blue);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 0;
            border-radius: 8px;
            padding: 10px 14px;
            font-weight: 700;
            cursor: pointer;
            background: var(--orange);
            color: #fff;
            font-size: 13px;
        }

        .btn:hover {
            background: #df5713;
        }

        .btn.light {
            background: #fff;
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .btn.danger {
            background: #fff0f0;
            color: #b42332;
        }

        .grid {
            display: grid;
            gap: 16px;
        }

        .stats {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-bottom: 18px;
        }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 18px;
            box-shadow: 0 2px 10px #17233708;
            min-width: 0;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: var(--orange-light);
            color: var(--orange);
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -1px;
            margin: 8px 0 2px;
        }

        .stat-foot {
            font-size: 11px;
            color: var(--muted);
        }

        .positive {
            color: var(--green);
            font-weight: 700;
        }

        .dashboard-grid {
            grid-template-columns: minmax(0, 1.55fr) minmax(0, 1fr);
            margin-bottom: 18px;
        }

        .card-title {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: center;
            margin-bottom: 14px;
        }

        .card-title h2 {
            font-size: 16px;
            margin: 0;
        }

        .card-title p {
            font-size: 12px;
            color: var(--muted);
            margin: 3px 0 0;
        }

        .chart {
            height: 205px;
            display: flex;
            align-items: end;
            gap: 13px;
            padding: 12px 4px 0;
            border-bottom: 1px solid var(--line);
        }

        .bar-group {
            flex: 1;
            height: 100%;
            display: flex;
            align-items: end;
            justify-content: center;
            gap: 4px;
            position: relative;
        }

        .bar {
            width: 13px;
            border-radius: 5px 5px 0 0;
            min-height: 3px;
        }

        .bar.current {
            background: #1769aa;
        }

        .bar.target {
            background: #34465e;
        }

        .bar-label {
            position: absolute;
            bottom: -24px;
            font-size: 10px;
            color: var(--muted);
            white-space: nowrap;
        }

        .legend {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 32px;
            font-size: 11px;
            color: var(--muted);
            flex-wrap: wrap;
        }

        .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 3px;
            margin-right: 5px;
        }

        .progress-row {
            margin: 15px 0;
        }

        .progress-meta {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .progress {
            height: 8px;
            background: #edf1f6;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress span {
            height: 100%;
            display: block;
            background: var(--blue);
            border-radius: 10px;
        }

        .level-list {
            display: grid;
            gap: 13px;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .field,
        select,
        textarea {
            width: 100%;
            border: 1px solid #dce3ec;
            border-radius: 8px;
            padding: 10px 11px;
            font: inherit;
            background: #fff;
            color: var(--ink);
        }

        .filters .field {
            width: auto;
            min-width: 180px;
        }

        .filters select {
            width: auto;
            min-width: 130px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 680px;
        }

        th {
            text-align: left;
            color: #8793a4;
            font-size: 10px;
            letter-spacing: .7px;
            text-transform: uppercase;
            font-weight: 800;
            background: #fbfcfe;
        }

        th, td {
            padding: 13px 12px;
            border-bottom: 1px solid #edf0f5;
        }

        td {
            font-size: 12px;
        }

        tbody tr:hover {
            background: #fbfdff;
        }

        .person {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .mini-avatar {
            width: 31px;
            height: 31px;
            display: grid;
            place-items: center;
            background: #e8f2fc;
            color: #1769aa;
            border-radius: 50%;
            font-weight: 800;
            flex-shrink: 0;
        }

        .person b {
            display: block;
            font-size: 12px;
        }

        .person small {
            color: var(--muted);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 800;
            background: #eaf8f2;
            color: #16805f;
        }

        .badge.warning {
            background: #fff5df;
            color: #a96b00;
        }

        .badge.danger {
            background: #ffebee;
            color: #bb3445;
        }

        .badge.neutral {
            background: #edf2f7;
            color: #5c6878;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .form-group.full {
            grid-column: 1/-1;
        }

        .form-actions {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 9px;
            background: #eaf8f2;
            color: #116a4d;
            margin-bottom: 16px;
        }

        .pagination {
            padding-top: 15px;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: var(--muted);
        }

        .footer {
            padding: 20px 0 0;
            text-align: center;
            color: #9aa5b4;
            font-size: 11px;
            border-top: 1px solid #e8edf2;
            margin-top: 30px;
        }

        /* LAPIS GELAP DI BELAKANG DRAWER */
        .sidebar-overlay {
            display: none;
        }

        /* RESPONSIVE LAPTOP / RESTORE DOWN */
        @media (max-width: 1100px) {
            .menu-toggle {
                display: inline-flex;
            }

            .sidebar {
                position: fixed;
                top: 65px;
                bottom: 0;
                left: 0;
                width: 265px;
                z-index: 1200;
                transform: translateX(-100%);
                box-shadow: 8px 0 25px #17233725;
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 65px 0 0;
                background: #10182780;
                z-index: 1100;
            }

            body.sidebar-open .sidebar-overlay {
                display: block;
            }

            main {
                width: 100%;
                padding: 22px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* TABLET */
        @media (max-width: 768px) {
            .topbar {
                padding: 0 14px;
            }

            .brand img {
                height: 36px;
                max-width: 125px;
            }

            .brand {
                font-size: 15px;
            }

            main {
                padding: 18px 14px 30px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .card {
                padding: 14px;
            }

            .stat-number {
                font-size: 25px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* HP */
        @media (max-width: 480px) {
            .topbar {
                height: 60px;
                padding: 0 10px;
            }

            .menu-toggle {
                width: 36px;
                height: 36px;
                font-size: 21px;
            }

            .brand {
                gap: 7px;
                font-size: 13px;
            }

            .brand img {
                height: 32px;
                max-width: 100px;
            }

            .brand-text small {
                font-size: 8px;
            }

            .sidebar {
                top: 60px;
                width: min(280px, 85vw);
            }

            .sidebar-overlay {
                inset: 60px 0 0;
            }

            main {
                padding: 15px 10px 25px;
            }

            .page-head {
                align-items: flex-start;
            }

            .page-head h1 {
                font-size: 20px;
            }

            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .card {
                padding: 12px;
                border-radius: 9px;
            }

            .stat-number {
                font-size: 22px;
            }

            .stat-top {
                font-size: 10px;
            }

            .stat-icon {
                width: 30px;
                height: 30px;
                font-size: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .filters .field,
            .filters select {
                width: 100%;
                min-width: 0;
            }

            .btn {
                padding: 9px 11px;
                font-size: 12px;
            }

            .chart {
                gap: 6px;
            }
        }

        /* PRINT */
        @media print {
            .topbar,
            .sidebar,
            .sidebar-overlay,
            .menu-toggle,
            .no-print,
            .footer {
                display: none !important;
            }

            .shell {
                display: block;
            }

            main {
                padding: 0;
                background: #fff;
            }

            .card {
                box-shadow: none;
                break-inside: avoid;
            }

            body {
                background: #fff;
            }
        }
    </style>

    @stack('head')
</head>

<body>

<header class="topbar">
    <div class="header-left">

        <button
            type="button"
            class="menu-toggle"
            id="menuToggle"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            aria-controls="sidebar"
        >
            ☰
        </button>

        

        <a class="brand" href="{{ route('dashboard') }}">
            <img
                src="{{ asset('images/pratama-logo.png') }}"
                alt="Logo Pratama"
            >

            <div class="brand-text">
                <strong>PRATAMA</strong>
                <small>SKILL MATRIX SYSTEM</small>
            </div>
        </a>

    </div>
</header>

<div class="shell">

    <aside class="sidebar" id="sidebar">

        
        <div class="profile">
            <div class="avatar">
                @if(auth()->user()->profile_photo)
                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                        alt="Foto Profil"
                        class="profile-image"
                    >
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                @endif
            </div>

            <strong>{{ auth()->user()->name ?? 'Administrator HR' }}</strong>
            <small>Human Resources Department</small>
        </div>


        <div class="nav-label">MENU UTAMA</div>

        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           href="{{ route('dashboard') }}">
            <span class="nav-icon">▦</span>
            <span class="label">Dashboard</span>
        </a>

        <div class="nav-label">MASTER DATA</div>

        <a class="nav-link {{ request()->routeIs('skills.*') ? 'active' : '' }}"
           href="{{ route('skills.index') }}">
            <span class="nav-icon">✧</span>
            <span class="label">Master Skill</span>
        </a>

        <div class="nav-label">ASSESSMENT</div>

        <a class="nav-link {{ request()->routeIs('assessments.*') ? 'active' : '' }}"
           href="{{ route('assessments.index') }}">
            <span class="nav-icon">✓</span>
            <span class="label">Penilaian Skill</span>
        </a>

        <a class="nav-link {{ request()->routeIs('reports.skill-gap') ? 'active' : '' }}"
           href="{{ route('reports.skill-gap') }}">
            <span class="nav-icon">▥</span>
            <span class="label">Skill Gap Analysis</span>
        </a>

        <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}"
           href="{{ route('reports.index') }}">
            <span class="nav-icon">▤</span>
            <span class="label">Laporan & Cetak</span>
        </a>

        <div class="nav-label">PENGEMBANGAN</div>

        <a class="nav-link {{ request()->routeIs('training.*') ? 'active' : '' }}"
           href="{{ route('reports.skill-gap') }}">
            <span class="nav-icon">◎</span>
            <span class="label">Rencana Training</span>
        </a>

        <a class="nav-link"
           href="{{ route('reports.index') }}">
            <span class="nav-icon">◷</span>
            <span class="label">Riwayat Assessment</span>
        </a>

        <div class="nav-label">SISTEM</div>

        @if(Route::has('activity-logs.index'))
            <a class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"
               href="{{ route('activity-logs.index') }}">
                <span class="nav-icon">◉</span>
                <span class="label">Log Aktivitas Web</span>
            </a>
        @endif

        <a class="nav-link" href="{{ route('reports.index') }}">
            <span class="nav-icon">⚙</span>
            <span class="label">Pengaturan</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">
                Logout
            </button>
        </form>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert" style="background:#ffebee;color:#a52435">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')

        <div class="footer">
            HRM Skill Matrix · Sistem Assessment Kompetensi Karyawan
        </div>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menuToggle');
    const overlay = document.getElementById('sidebarOverlay');
    const sidebar = document.getElementById('sidebar');

    function openMenu() {
        document.body.classList.add('sidebar-open');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.innerHTML = '&times;';
    }

    function closeMenu() {
        document.body.classList.remove('sidebar-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.innerHTML = '&#9776;';
    }

    toggle.addEventListener('click', function () {
        if (document.body.classList.contains('sidebar-open')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener('click', closeMenu);

    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 1100) {
                closeMenu();
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 1100) {
            closeMenu();
        }
    });
});
</script>

@stack('scripts')

</body>
</html>