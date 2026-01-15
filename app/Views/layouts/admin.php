<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin' ?> | bunlar.online</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); }
        .sidebar .nav-link { color: rgba(255,255,255,0.7); padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 0.25rem; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.15); }
        .sidebar .nav-link i { width: 24px; }
        .sidebar-header { padding: 1.5rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h5 { color: #fff; margin: 0; }
        .main-content { padding: 2rem; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border-radius: 0.75rem; }
        .card-header { background: transparent; border-bottom: 1px solid rgba(0,0,0,0.05); font-weight: 600; }
        .btn { border-radius: 0.5rem; }
        .table { margin-bottom: 0; }
        .badge { font-weight: 500; }
        @media (max-width: 768px) {
            .sidebar { min-height: auto; }
            .main-content { padding: 1rem; }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
                <div class="sidebar-header">
                    <h5><i class="bi bi-link-45deg me-2"></i>bunlar.online</h5>
                </div>
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column px-2">
                        <li class="nav-item">
                            <a class="nav-link <?= uri_string() === 'admin' || uri_string() === 'admin/dashboard' ? 'active' : '' ?>" href="/admin/dashboard">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/analytics') ? 'active' : '' ?>" href="/admin/analytics">
                                <i class="bi bi-graph-up me-2"></i> Analitik
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted text-uppercase">
                        <span style="font-size: 0.7rem; color: rgba(255,255,255,0.4);">Linktree</span>
                    </h6>
                    <ul class="nav flex-column px-2">
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/profiles') ? 'active' : '' ?>" href="/admin/profiles">
                                <i class="bi bi-person-circle me-2"></i> Profiller
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/profile-links') ? 'active' : '' ?>" href="/admin/profile-links">
                                <i class="bi bi-list-ul me-2"></i> Profil Linkleri
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted text-uppercase">
                        <span style="font-size: 0.7rem; color: rgba(255,255,255,0.4);">URL Shortener</span>
                    </h6>
                    <ul class="nav flex-column px-2">
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/short-links') ? 'active' : '' ?>" href="/admin/short-links">
                                <i class="bi bi-link me-2"></i> Kisa Linkler
                            </a>
                        </li>
                    </ul>

                    <ul class="nav flex-column px-2 mt-4 border-top pt-3" style="border-color: rgba(255,255,255,0.1) !important;">
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="/logout">
                                <i class="bi bi-box-arrow-right me-2"></i> Cikis Yap
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <!-- Mobile Toggle -->
                <div class="d-md-none mb-3">
                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                        <i class="bi bi-list"></i> Menu
                    </button>
                </div>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>