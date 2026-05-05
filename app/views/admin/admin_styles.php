<?php $base = "http://localhost/appointment_booking_system"; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Ponomar&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --pink:   #ff2768;
        --white:  #ffffff;
        --label:  #c0024e;
        --text:   #1a1a2e;
        --sub:    #555;
        --light:  #fff0f5;
        --border: #f9a8c4;
        --shadow: rgba(255, 39, 104, 0.12);
        --sidebar-w: 230px;
    }

    html, body { height: 100%; font-family: "Ponomar", serif; background: #fdf4f7; color: var(--text); }
    .layout { display: flex; min-height: 100vh; }

    .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 99; }
    .overlay.open { display: block; }

    /* SIDEBAR */
    .sidebar {
        width: var(--sidebar-w); flex-shrink: 0;
        background: linear-gradient(160deg, #fff 0%, #ffe0ec 60%, var(--pink) 100%);
        display: flex; flex-direction: column;
        padding: 28px 18px; border-right: 1px solid var(--border);
        min-height: 100vh; position: relative; z-index: 100;
        transition: transform 0.3s ease;
    }
    .sidebar-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 36px; text-decoration: none; }
    .sidebar-brand img { width: 40px; height: 40px; object-fit: contain; }
    .sidebar-brand span { font-size: 1rem; font-weight: 700; color: var(--text); line-height: 1.2; }
    .sidebar nav { flex: 1; }
    .nav-section { font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--label); margin: 18px 0 8px 8px; }
    .nav-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 12px; color: var(--text); text-decoration: none; font-size: 0.92rem; transition: background 0.2s, color 0.2s; margin-bottom: 4px; }
    .nav-item i { width: 18px; text-align: center; color: var(--pink); }
    .nav-item:hover, .nav-item.active { background: rgba(255,39,104,0.12); color: var(--pink); }
    .nav-item.active { font-weight: 700; }
    .sidebar-footer { border-top: 1px solid var(--border); padding-top: 16px; }
    .admin-tag { font-size: 0.75rem; color: var(--sub); text-align: center; }
    .admin-tag strong { color: var(--pink); display: block; font-size: 0.9rem; }

    /* MAIN */
    .main { flex: 1; padding: 28px 32px; overflow-y: auto; min-width: 0; }
    .topbar { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
    .topbar h1 { font-size: 1.6rem; color: var(--text); font-weight: 400; }
    .topbar span { font-size: 0.85rem; color: var(--sub); display: block; }

    .hamburger {
        display: none; background: var(--white); border: 1px solid var(--border);
        border-radius: 10px; width: 40px; height: 40px;
        align-items: center; justify-content: center;
        cursor: pointer; color: var(--pink); font-size: 1.1rem; flex-shrink: 0;
    }

    /* STAT CARDS */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
    .stat-card { background: var(--white); border-radius: 16px; padding: 20px 18px; box-shadow: 0 4px 20px var(--shadow); border: 1px solid #fde8ef; display: flex; align-items: center; gap: 14px; }
    .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .stat-icon.total     { background: #ffe0ec; color: var(--pink); }
    .stat-icon.pending   { background: #fff3cd; color: #b88000; }
    .stat-icon.confirmed { background: #d4edda; color: #1a7a34; }
    .stat-icon.cancelled { background: #f8d7da; color: #721c24; }
    .stat-icon.blue      { background: #d0eaff; color: #0057b8; }
    .stat-icon.purple    { background: #ede0ff; color: #6200ea; }
    .stat-info p  { font-size: 0.75rem; color: var(--sub); margin-bottom: 3px; }
    .stat-info h2 { font-size: 1.6rem; font-weight: 700; color: var(--text); }

    /* SECTION CARD / TABLE */
    .section-card { background: var(--white); border-radius: 16px; box-shadow: 0 4px 20px var(--shadow); border: 1px solid #fde8ef; overflow: hidden; margin-bottom: 24px; }
    .section-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 16px 20px; border-bottom: 1px solid #fde8ef; }
    .section-header h2 { font-size: 1rem; font-weight: 700; color: var(--text); }

    .search-bar { display: flex; align-items: center; background: var(--light); border: 1px solid var(--border); border-radius: 50px; padding: 6px 14px; gap: 8px; }
    .search-bar input { border: none; background: transparent; font-family: "Ponomar", serif; font-size: 0.85rem; color: var(--text); outline: none; width: 160px; }
    .search-bar i { color: var(--pink); font-size: 0.85rem; }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 0.87rem; min-width: 500px; }
    thead th { background: var(--light); color: var(--label); font-size: 0.72rem; letter-spacing: 0.06em; text-transform: uppercase; padding: 11px 14px; text-align: left; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #fde8ef; transition: background 0.15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fff8fb; }
    tbody td { padding: 12px 14px; color: var(--text); white-space: nowrap; }

    .badge { display: inline-block; padding: 3px 11px; border-radius: 50px; font-size: 0.73rem; font-weight: 700; }
    .badge.confirmed, .badge.active   { background: #d4edda; color: #1a7a34; }
    .badge.pending                    { background: #fff3cd; color: #b88000; }
    .badge.cancelled, .badge.inactive { background: #f8d7da; color: #721c24; }

    .action-btns { display: flex; gap: 5px; flex-wrap: wrap; }
    .btn-sm { padding: 5px 11px; border-radius: 50px; border: none; font-family: "Ponomar", serif; font-size: 0.75rem; cursor: pointer; transition: opacity 0.2s; white-space: nowrap; }
    .btn-sm:hover  { opacity: 0.75; }
    .btn-confirm   { background: #d4edda; color: #1a7a34; }
    .btn-cancel    { background: #f8d7da; color: #721c24; }
    .btn-view      { background: var(--light); color: var(--pink); border: 1px solid var(--border); }
    .btn-edit      { background: #d0eaff; color: #0057b8; }
    .btn-delete    { background: #f8d7da; color: #721c24; }
    .btn-primary   { background: var(--pink); color: var(--white); padding: 8px 18px; border-radius: 50px; border: none; font-family: "Ponomar", serif; font-size: 0.88rem; cursor: pointer; transition: opacity 0.2s; }
    .btn-primary:hover { opacity: 0.85; }

    /* FORM CARD */
    .form-card { background: var(--white); border-radius: 16px; box-shadow: 0 4px 20px var(--shadow); border: 1px solid #fde8ef; padding: 28px 28px; margin-bottom: 24px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: 0.78rem; color: var(--label); letter-spacing: 0.04em; text-transform: uppercase; }
    .form-group input, .form-group select, .form-group textarea {
        padding: 10px 16px; border-radius: 50px; border: 1.5px solid var(--border);
        background: #fff8fb; font-family: "Ponomar", serif; font-size: 0.9rem;
        color: var(--text); outline: none; transition: border-color 0.2s;
    }
    .form-group textarea { border-radius: 14px; resize: vertical; min-height: 80px; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--pink); }
    .form-actions { margin-top: 20px; display: flex; gap: 10px; }

    /* RESPONSIVE */
    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .sidebar { position: fixed; top: 0; left: 0; height: 100%; transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); }
        .hamburger { display: flex; }
        .main { padding: 20px 16px; }
        .topbar h1 { font-size: 1.3rem; }
        .form-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        .stat-card { padding: 14px 12px; gap: 10px; }
        .stat-icon { width: 38px; height: 38px; font-size: 1rem; }
        .stat-info h2 { font-size: 1.2rem; }
        .search-bar input { width: 110px; }
    }
</style>