<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iridis Attendance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const STORAGE_KEY = 'iridis-theme';
	const saved = localStorage.getItem(STORAGE_KEY) || 'dark';
	document.documentElement.setAttribute('data-theme', saved);
    </script>

    <!-- Bootstrap 5 & DataTables CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════
           CSS VARIABLES — DARK & LIGHT THEMES
        ═══════════════════════════════════════ */
        :root,
        [data-theme="dark"] {
            --bg:          #0b0f1a;
            --bg2:         #111827;
            --surface:     #111827;
            --surface2:    #1a2236;
            --surface3:    #222d44;
            --border:      rgba(255,255,255,0.07);
            --border-soft: rgba(255,255,255,0.04);
            --accent:      #4f8ef7;
            --accent-glow: rgba(79,142,247,0.18);
            --accent-dim:  rgba(79,142,247,0.1);
            --success:     #22d3a5;
            --danger:      #f75c6e;
            --warning:     #f9c846;
            --info:        #7eb8f7;
            --text:        #e8edf5;
            --text-soft:   #a8b5cc;
            --muted:       #6b7a99;
            --nav-bg:      rgba(11,15,26,0.92);
            --nav-border:  rgba(79,142,247,0.15);
            --footer-bg:   #0d1220;
            --radius:      14px;
            --shadow:      0 4px 32px rgba(0,0,0,0.45);
            --shadow-sm:   0 2px 12px rgba(0,0,0,0.3);
        }

        [data-theme="light"] {
            --bg:          #f0f4fb;
            --bg2:         #e8eef8;
            --surface:     #ffffff;
            --surface2:    #f4f7fd;
            --surface3:    #eaeff8;
            --border:      rgba(0,0,0,0.08);
            --border-soft: rgba(0,0,0,0.04);
            --accent:      #2563eb;
            --accent-glow: rgba(37,99,235,0.12);
            --accent-dim:  rgba(37,99,235,0.07);
            --success:     #059669;
            --danger:      #dc2626;
            --warning:     #d97706;
            --info:        #2563eb;
            --text:        #111827;
            --text-soft:   #374151;
            --muted:       #6b7280;
            --nav-bg:      rgba(255,255,255,0.92);
            --nav-border:  rgba(37,99,235,0.12);
            --footer-bg:   #e8eef8;
            --radius:      14px;
            --shadow:      0 4px 32px rgba(0,0,0,0.09);
            --shadow-sm:   0 2px 12px rgba(0,0,0,0.06);
        }

        /* ═══════════════════════════════════════
           BASE
        ═══════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s, color 0.3s;
        }

        /* ═══════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════ */
        .navbar {
            background: var(--nav-bg) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--nav-border);
            padding: 0 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
            transition: background 0.3s, border-color 0.3s;
        }

        .navbar .container {
            height: 62px;
        }

        /* Brand */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand img {
            height: 34px;
            width: auto;
            border-radius: 6px;
        }
        .brand-text {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: -0.3px;
            color: var(--text);
            transition: color 0.3s;
        }
        .brand-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            margin-left: 2px;
            vertical-align: middle;
            margin-bottom: 3px;
        }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav-links .nav-item { position: relative; }

        .nav-links .nav-link {
            font-family: 'Syne', sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--muted) !important;
            padding: 8px 12px !important;
            border-radius: 8px;
            text-decoration: none;
            transition: color 0.2s, background 0.2s;
            white-space: nowrap;
        }
        .nav-links .nav-link:hover {
            color: var(--text) !important;
            background: var(--accent-dim);
        }
        .nav-links .nav-link.active {
            color: var(--accent) !important;
            background: var(--accent-dim);
        }

        /* User dropdown */
        .nav-links .dropdown-toggle::after {
            border-color: var(--muted) transparent transparent;
            opacity: 0.6;
        }
        .nav-links .dropdown-menu {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 6px;
            min-width: 160px;
        }
        .nav-links .dropdown-item {
            font-family: 'Syne', sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--text-soft);
            border-radius: 7px;
            padding: 8px 12px;
            transition: background 0.15s, color 0.15s;
        }
        .nav-links .dropdown-item:hover {
            background: var(--accent-dim);
            color: var(--accent);
        }

        /* ── Theme toggle ── */
        .theme-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 8px;
        }
        .toggle-track {
            position: relative;
            width: 44px;
            height: 24px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.3s, border-color 0.3s;
            flex-shrink: 0;
        }
        .toggle-track:hover { border-color: var(--accent); }
        .toggle-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--accent);
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
        }
        [data-theme="light"] .toggle-thumb {
            transform: translateX(20px);
        }
        .toggle-icon {
            font-size: 0.8rem;
            user-select: none;
            line-height: 1;
        }

        /* ── Navbar divider ── */
        .nav-divider {
            width: 1px;
            height: 20px;
            background: var(--border);
            margin: 0 6px;
        }

        /* ═══════════════════════════════════════
           BODY / FOOTER
        ═══════════════════════════════════════ */
        .body-container {
            flex: 1;
            padding-top: 28px;
            padding-bottom: 40px;
        }

        footer {
            padding: 14px 0;
            background: var(--footer-bg);
            border-top: 1px solid var(--border);
            text-align: center;
            font-family: 'DM Mono', monospace;
            font-size: 0.72rem;
            color: var(--muted);
            letter-spacing: 0.5px;
            transition: background 0.3s;
        }

        /* ═══════════════════════════════════════
           GLOBAL FORM CONTROLS
        ═══════════════════════════════════════ */
        .form-control, .form-select {
            background: var(--surface2) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            color: var(--text) !important;
            font-family: 'DM Mono', monospace !important;
            font-size: 0.82rem !important;
            padding: 9px 13px !important;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px var(--accent-glow) !important;
            outline: none !important;
        }
        .form-control::placeholder { color: var(--muted) !important; }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.5);
            cursor: pointer;
        }

        /* ═══════════════════════════════════════
           FILTER CARD (shared)
        ═══════════════════════════════════════ */
        .filter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px 18px;
            margin-bottom: 28px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: background 0.3s, border-color 0.3s;
        }
        .filter-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), transparent);
        }
        .filter-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            display: block;
            margin-bottom: 6px;
        }
        .btn-filter {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 1px;
            padding: 9px 28px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 18px var(--accent-glow);
        }
        .btn-filter:hover {
            opacity: 0.88;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px var(--accent-glow);
        }
        .btn-filter:active { transform: translateY(0); }

        /* ═══════════════════════════════════════
           SUMMARY CARDS (shared)
        ═══════════════════════════════════════ */
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 28px;
        }
        .summary-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 26px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.2s, background 0.3s;
        }
        .summary-card:hover { transform: translateY(-2px); }
        .summary-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
        }
        .summary-card.checkin::after  { background: var(--success); }
        .summary-card.checkout::after { background: var(--danger); }
        .summary-card .s-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
        }
        .summary-card .s-value {
            font-family: 'Syne', sans-serif;
            font-size: 2.6rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -2px;
        }
        .summary-card.checkin  .s-value { color: var(--success); }
        .summary-card.checkout .s-value { color: var(--danger); }
        .summary-card .s-icon {
            position: absolute;
            right: 20px; top: 50%;
            transform: translateY(-50%);
            font-size: 2.8rem;
            opacity: 0.07;
        }

        /* ═══════════════════════════════════════
           PAGE HEADER (shared)
        ═══════════════════════════════════════ */
        .att-header {
            display: flex;
            align-items: flex-end;
            gap: 18px;
            margin-bottom: 28px;
        }
        .att-header h1 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            letter-spacing: -1px;
            color: var(--text);
            margin: 0;
            line-height: 1;
            transition: color 0.3s;
        }
        .att-header .header-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
            margin-bottom: 6px;
            opacity: 0.4;
        }

        /* ═══════════════════════════════════════
           TABLE WRAPPER (shared)
        ═══════════════════════════════════════ */
        .table-wrapper {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: visible;
            box-shadow: var(--shadow);
            transition: background 0.3s;
        }
        div.dataTables_wrapper {
            color: var(--text) !important;
            font-size: 0.8rem;
            padding: 18px 20px;
        }
        div.dataTables_wrapper .dataTables_info,
        div.dataTables_wrapper .dataTables_length label,
        div.dataTables_wrapper .dataTables_filter label {
            color: var(--muted) !important;
            font-size: 0.75rem;
        }
        div.dataTables_wrapper input,
        div.dataTables_wrapper select {
            background: var(--surface2) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 6px !important;
            padding: 4px 8px !important;
            font-family: 'DM Mono', monospace !important;
            font-size: 0.78rem !important;
        }
        table.dataTable thead th {
            background: var(--surface2) !important;
            color: var(--muted) !important;
            font-family: 'Syne', sans-serif !important;
            font-size: 0.6rem !important;
            font-weight: 700 !important;
            letter-spacing: 2px !important;
            text-transform: uppercase !important;
            border: none !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 13px 16px !important;
            transition: background 0.3s;
        }
        table.dataTable tbody tr {
            border-bottom: 1px solid var(--border) !important;
            transition: background 0.15s;
            background: var(--surface) !important;
        }
        table.dataTable tbody tr:hover {
            background: var(--accent-dim) !important;
        }
        table.dataTable tbody td {
            border: none !important;
            padding: 12px 16px !important;
            color: var(--text) !important;
            font-size: 0.8rem !important;
            vertical-align: middle !important;
        }
        table.dataTable tbody tr:last-child td { border-bottom: none !important; }

        /* Badges */
        .badge {
            font-family: 'Syne', sans-serif !important;
            font-size: 0.80rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.8px !important;
            padding: 4px 10px !important;
            border-radius: 20px !important;
        }
        .badge.bg-success  { background: rgba(34,211,165,0.15) !important; color: var(--success) !important; }
        .badge.bg-danger   { background: rgba(247,92,110,0.15) !important; color: var(--danger) !important; }
        .badge.bg-info     { background: rgba(126,184,247,0.15) !important; color: var(--info) !important; }
        .badge.bg-warning  { background: rgba(249,200,70,0.13) !important; color: var(--warning) !important; }

        /* DataTables export buttons */
        .dt-buttons .dt-button {
            background: var(--surface2) !important;
            color: var(--muted) !important;
            border: 1px solid var(--border) !important;
            border-radius: 7px !important;
            font-family: 'Syne', sans-serif !important;
            font-size: 0.68rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            padding: 5px 14px !important;
            margin-right: 4px !important;
            transition: all 0.2s !important;
        }
        .dt-buttons .dt-button:hover {
            background: var(--accent) !important;
            color: #fff !important;
            border-color: var(--accent) !important;
        }

        /* Pagination */
        .dataTables_paginate .paginate_button {
            background: var(--surface2) !important;
            color: var(--muted) !important;
            border: 1px solid var(--border) !important;
            border-radius: 6px !important;
            font-family: 'DM Mono', monospace !important;
            font-size: 0.72rem !important;
            padding: 4px 10px !important;
            margin: 0 2px !important;
            transition: all 0.2s;
        }
        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button:hover {
            background: var(--accent) !important;
            color: #fff !important;
            border-color: var(--accent) !important;
        }
        .dataTables_processing {
            background: var(--surface) !important;
            color: var(--accent) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            font-family: 'Syne', sans-serif !important;
            font-size: 0.8rem !important;
        }
        ul.pagination { margin-bottom: 30px !important; }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 768px) {
            .nav-links { gap: 0; }
            .nav-links .nav-link { padding: 6px 8px !important; font-size: 0.65rem; }
            .summary-grid { grid-template-columns: 1fr; }
            .att-header h1 { font-size: 1.7rem; }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('devices.Attendance') }}">
                <img src="/logo.png" alt="Iridis Logo">
                <span class="brand-text">Iridis<span class="brand-dot"></span></span>
            </a>

            @if (Auth::check())
            <ul class="nav-links">
                <li class="nav-item"><a class="nav-link" href="{{ route('devices.Attendance') }}">Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('devices.daily') }}">Daily</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('devices.monthly') }}">Monthly</a></li>
                @if (Auth::user()->is_admin)
                    <li class="nav-item"><a class="nav-link" href="{{ route('devices.index') }}">Devices</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Admins</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('employee.MapId') }}">Map Employee</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="{{ route('password.change') }}">Password</a></li>

                <li class="nav-divider"></li>

                <!-- User dropdown -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

                <li class="nav-divider"></li>

                <!-- Theme toggle -->
                <li class="nav-item">
                    <div class="theme-toggle" title="Toggle theme">
                        <span class="toggle-icon">🌙</span>
                        <div class="toggle-track" id="themeToggle">
                            <div class="toggle-thumb"></div>
                        </div>
                        <span class="toggle-icon">☀️</span>
                    </div>
                </li>
            </ul>
            @endif

        </div>
    </nav>

    <div class="container body-container">
        @yield('content')
        @yield('scripts')
    </div>

    <footer>
        &copy; {{ now()->year }} Iridis Attendance — All rights reserved.
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        // Define variables now that the DOM elements actually exist
        const html = document.documentElement;
        const toggleTrack = document.getElementById('themeToggle');

        // Set up click action (only if the button is found on this page)
        if (toggleTrack) {
            toggleTrack.addEventListener('click', function () {
                const current = html.getAttribute('data-theme');
                const next    = current === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem(STORAGE_KEY, next);
            });
        }

        // ── Active nav link ───────────────────────────────
        document.querySelectorAll('.nav-links .nav-link').forEach(link => {
            if (link.href === window.location.href) link.classList.add('active');
        });
    </script>

</body>
</html>

