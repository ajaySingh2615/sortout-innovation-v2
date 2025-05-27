<?php
// ✅ Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Ensure Correct Path for Database Connection
require_once __DIR__ . '/../includes/db_connect.php';

// ✅ Ensure Only Admins & Super Admins Can Access
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'super_admin')) {
    header("Location: ../auth/login.php");
    exit();
}

// ✅ Fetch statistics
$pendingCount = $conn->query("SELECT COUNT(*) as count FROM clients WHERE approval_status = 'pending'")->fetch_assoc()['count'];
$approvedCount = $conn->query("SELECT COUNT(*) as count FROM clients WHERE approval_status = 'approved'")->fetch_assoc()['count'];
$rejectedCount = $conn->query("SELECT COUNT(*) as count FROM clients WHERE approval_status = 'rejected'")->fetch_assoc()['count'];
$totalCount = $conn->query("SELECT COUNT(*) as count FROM clients")->fetch_assoc()['count'];

// ✅ Fetch new registrations (last 2 hours)
$newCount = $conn->query("SELECT COUNT(*) as count FROM clients WHERE created_at >= DATE_SUB(NOW(), INTERVAL 2 HOUR)")->fetch_assoc()['count'];
$todayCount = $conn->query("SELECT COUNT(*) as count FROM clients WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];
$pendingTodayCount = $conn->query("SELECT COUNT(*) as count FROM clients WHERE DATE(created_at) = CURDATE() AND approval_status = 'pending'")->fetch_assoc()['count'];

// ✅ Fetch recent registrations
$recentQuery = "SELECT * FROM clients ORDER BY created_at DESC LIMIT 10";
$recentResult = mysqli_query($conn, $recentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/sortoutInnovation-icon/sortout-innovation-only-s.gif" />
    <title>Registrations Dashboard - SortOut Innovation</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .stats-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background-color: #f8fafc;
            border: none;
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 0.75rem;
        }

        .table tbody td {
            border: none;
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-status {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .btn-action {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .profile-img:hover {
            transform: scale(1.1);
        }

        .filter-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .filter-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .filter-header h5 {
            margin: 0;
            color: #1f2937;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .filter-header i {
            color: var(--primary-color);
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }

        .filter-row-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.05) 0%, transparent 100%);
        }

        .search-input {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background: white;
            transform: translateY(-1px);
        }

        .form-select {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background: white;
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .quick-filters-section {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 1px solid #d1d5db;
        }

        .quick-filters-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .quick-filters-title i {
            color: var(--info-color);
            margin-right: 0.5rem;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
        }

        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .whatsapp-link {
            color: #25d366;
            text-decoration: none;
        }

        .whatsapp-link:hover {
            color: #128c7e;
        }

        .instagram-link {
            color: #e4405f;
            text-decoration: none;
        }

        .instagram-link:hover {
            color: #c13584;
        }

        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            border: none;
            color: var(--secondary-color);
            padding: 0.75rem 1rem;
            margin: 0 0.125rem;
            border-radius: 6px;
        }

        .page-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 2rem;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--secondary-color);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* New Registration Indicators */
        .new-registration {
            background: linear-gradient(135deg, #fef3c7 0%, #fbbf24 100%);
            border-left: 4px solid #f59e0b;
            animation: pulse-glow 2s infinite;
        }

        .new-today {
            background: linear-gradient(135deg, #dbeafe 0%, #3b82f6 100%);
            border-left: 4px solid #2563eb;
        }

        .badge-new {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            animation: bounce 1s infinite;
        }

        .badge-today {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
        }

        .time-indicator {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        .time-new {
            color: #059669;
            font-weight: 600;
        }

        .time-today {
            color: #2563eb;
            font-weight: 600;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 5px rgba(245, 158, 11, 0.3); }
            50% { box-shadow: 0 0 20px rgba(245, 158, 11, 0.6); }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-3px); }
            60% { transform: translateY(-2px); }
        }

        .quick-filter-active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(37, 99, 235, 0.4);
        }

        .btn-quick-filter {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .btn-quick-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .btn-quick-filter::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-quick-filter:hover::before {
            left: 100%;
        }

        .filter-reset-btn {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            border: none;
            color: white;
        }

        .filter-reset-btn:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            color: white;
        }

        /* Professional Badge Styles */
        .badge-artist {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
        }

        .badge-artist:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
        }

        .badge-employee {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
        }

        .badge-employee:hover {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);
        }

        /* Influencer Info Styles */
        .influencer-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            min-width: 180px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.125rem 0;
        }

        .info-item i {
            width: 12px;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .info-text {
            font-size: 0.75rem;
            line-height: 1.2;
            font-weight: 500;
        }

        /* Enhanced Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.25rem;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-action:hover::before {
            left: 100%;
        }

        /* View Button */
        .btn-view {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border-color: #3b82f6;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: white;
            border-color: #1d4ed8;
        }

        /* Approve Button */
        .btn-approve {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #10b981;
        }

        .btn-approve:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border-color: #059669;
        }

        /* Reject Button */
        .btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-color: #ef4444;
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            border-color: #dc2626;
        }

        /* Edit Button */
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border-color: #f59e0b;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: white;
            border-color: #d97706;
        }

        /* Visibility Buttons */
        .btn-hide {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border-color: #6b7280;
        }

        .btn-hide:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            color: white;
            border-color: #4b5563;
        }

        .btn-show {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            border-color: #8b5cf6;
        }

        .btn-show:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            border-color: #7c3aed;
        }

        /* More Actions Button */
        .btn-more {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            border-color: #64748b;
        }

        .btn-more:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            color: white;
            border-color: #475569;
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            min-width: 160px;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border-radius: 0;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            transform: translateX(4px);
        }

        .dropdown-item i {
            width: 16px;
        }

        /* Loading state for buttons */
        .btn-action.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-action.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Simple Modal Styles */
        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-body {
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 12px;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
            
            .filter-section {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-users-cog me-2"></i>
                Registrations Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="model_agency_dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Main Dashboard
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../auth/logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <!-- Alert Container -->
        <div id="alertContainer"></div>

        <!-- New Registrations Alert -->
        <?php if ($newCount > 0): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-bell me-2"></i>
                <div>
                    <strong>New Registrations Alert!</strong>
                    <span class="badge bg-primary ms-2"><?= $newCount ?></span> new registration(s) in the last 2 hours.
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="quickFilter('last_24h')">
                        View Recent
                    </button>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Pending</h6>
                            <h3 class="card-title mb-0 fw-bold"><?= $pendingCount ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Approved</h6>
                            <h3 class="card-title mb-0 fw-bold"><?= $approvedCount ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-danger bg-opacity-10 text-danger me-3">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Rejected</h6>
                            <h3 class="card-title mb-0 fw-bold"><?= $rejectedCount ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stats-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total</h6>
                            <h3 class="card-title mb-0 fw-bold"><?= $totalCount ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-3">
                <div class="card table-card">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title mb-0">Registration Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card table-card">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title mb-0">Professional Types</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="professionalChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <div class="filter-header">
                <i class="fas fa-filter"></i>
                <h5>Advanced Filters</h5>
            </div>
            
            <div class="filter-row-title">
                <i class="fas fa-search me-2"></i>Basic Filters
            </div>
            <div class="row g-3">
                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Search</label>
                    <div class="position-relative">
                        <input type="text" id="searchInput" class="form-control search-input" placeholder="Search by name, phone, email...">
                        <i class="fas fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending">🕐 Pending</option>
                        <option value="approved">✅ Approved</option>
                        <option value="rejected">❌ Rejected</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Date Range</label>
                    <select id="dateFilter" class="form-select">
                        <option value="">📅 All Time</option>
                        <option value="today">📅 Today</option>
                        <option value="yesterday">📅 Yesterday</option>
                        <option value="last_24h">⏰ Last 24 Hours</option>
                        <option value="last_7_days">📅 Last 7 Days</option>
                        <option value="last_30_days">📅 Last 30 Days</option>
                        <option value="this_month">📅 This Month</option>
                        <option value="last_month">📅 Last Month</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-6">
                    <label class="form-label">Professional</label>
                    <select id="professionalFilter" class="form-select">
                        <option value="">All Types</option>
                        <option value="Artist">🎨 Artist</option>
                        <option value="Employee">👔 Employee</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Category</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        <option value="Dating App Host">💕 Dating App Host</option>
                        <option value="Video Live Streamers">📹 Video Live Streamers</option>
                        <option value="Voice Live Streamers">🎙️ Voice Live Streamers</option>
                        <option value="Singer">🎤 Singer</option>
                        <option value="Dancer">💃 Dancer</option>
                        <option value="Actor / Actress">🎭 Actor / Actress</option>
                        <option value="Model">📸 Model</option>
                        <option value="Artist / Painter">🎨 Artist / Painter</option>
                        <option value="Social Media Influencer">📱 Social Media Influencer</option>
                        <option value="Content Creator">📝 Content Creator</option>
                        <option value="Vlogger">📹 Vlogger</option>
                        <option value="Gamer / Streamer">🎮 Gamer / Streamer</option>
                        <option value="YouTuber">📺 YouTuber</option>
                        <option value="Anchor / Emcee / Host">🎤 Anchor / Emcee / Host</option>
                        <option value="DJ / Music Producer">🎧 DJ / Music Producer</option>
                        <option value="Photographer / Videographer">📷 Photographer / Videographer</option>
                        <option value="Makeup Artist / Hair Stylist">💄 Makeup Artist / Hair Stylist</option>
                        <option value="Fashion Designer / Stylist">👗 Fashion Designer / Stylist</option>
                        <option value="Fitness Trainer / Yoga Instructor">💪 Fitness Trainer / Yoga Instructor</option>
                        <option value="Motivational Speaker / Life Coach">🗣️ Motivational Speaker / Life Coach</option>
                        <option value="Chef / Culinary Artist">👨‍🍳 Chef / Culinary Artist</option>
                        <option value="Child Artist">👶 Child Artist</option>
                        <option value="Pet Performer / Pet Model">🐕 Pet Performer / Pet Model</option>
                        <option value="Instrumental Musician">🎻 Instrumental Musician</option>
                        <option value="Director / Scriptwriter / Editor">🎬 Director / Scriptwriter / Editor</option>
                        <option value="Voice Over Artist">🎙️ Voice Over Artist</option>
                        <option value="Magician / Illusionist">🎩 Magician / Illusionist</option>
                        <option value="Stand-up Comedian">😂 Stand-up Comedian</option>
                        <option value="Mimicry Artist">🎭 Mimicry Artist</option>
                        <option value="Poet / Storyteller">📖 Poet / Storyteller</option>
                        <option value="Language Trainer / Public Speaking Coach">🗣️ Language Trainer / Public Speaking Coach</option>
                        <option value="Craft Expert / DIY Creator">🔨 Craft Expert / DIY Creator</option>
                        <option value="Travel Blogger / Explorer">✈️ Travel Blogger / Explorer</option>
                        <option value="Astrologer / Tarot Reader">🔮 Astrologer / Tarot Reader</option>
                        <option value="Educator / Subject Matter Expert">📚 Educator / Subject Matter Expert</option>
                        <option value="Tech Reviewer / Gadget Expert">💻 Tech Reviewer / Gadget Expert</option>
                        <option value="Unboxing / Product Reviewer">📦 Unboxing / Product Reviewer</option>
                        <option value="Business Coach / Startup Mentor">💼 Business Coach / Startup Mentor</option>
                        <option value="Health & Wellness Coach">🌿 Health & Wellness Coach</option>
                        <option value="Event Anchor / Wedding Host">💒 Event Anchor / Wedding Host</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="form-label">City</label>
                    <select id="cityFilter" class="form-select">
                        <option value="">🏙️ All Cities</option>
                        <option value="Mumbai">🏙️ Mumbai</option>
                        <option value="Delhi">🏛️ Delhi</option>
                        <option value="Bangalore">🌆 Bangalore</option>
                        <option value="Hyderabad">🏙️ Hyderabad</option>
                        <option value="Ahmedabad">🏙️ Ahmedabad</option>
                        <option value="Chennai">🏙️ Chennai</option>
                        <option value="Kolkata">🏙️ Kolkata</option>
                        <option value="Pune">🏙️ Pune</option>
                        <option value="Jaipur">🏰 Jaipur</option>
                        <option value="Gurgaon">🏙️ Gurgaon</option>
                        <option value="Noida">🏙️ Noida</option>
                        <option value="Faridabad">🏙️ Faridabad</option>
                        <option value="Lucknow">🏙️ Lucknow</option>
                        <option value="Kanpur">🏙️ Kanpur</option>
                        <option value="Nagpur">🏙️ Nagpur</option>
                        <option value="Indore">🏙️ Indore</option>
                        <option value="Surat">🏙️ Surat</option>
                        <option value="Ludhiana">🏙️ Ludhiana</option>
                        <option value="Agra">🕌 Agra</option>
                        <option value="Patna">🏙️ Patna</option>
                    </select>
                </div>
            </div>
            
            <div class="filter-row-title mt-4">
                <i class="fas fa-star me-2"></i>Influencer Specific Filters
            </div>
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Influencer Category</label>
                    <select id="influencerCategoryFilter" class="form-select">
                        <option value="">🎯 All Influencer Categories</option>
                        <option value="Video Content Creators">📹 Video Content Creators</option>
                        <option value="Fashion Influencers">👗 Fashion Influencers</option>
                        <option value="Beauty Model for shooting">💄 Beauty Model for shooting</option>
                        <option value="Fitness and Health Influencers">💪 Fitness and Health Influencers</option>
                        <option value="Lifestyle Influencers">🌟 Lifestyle Influencers</option>
                        <option value="Travel Influencers">✈️ Travel Influencers</option>
                        <option value="Food Influencers">🍕 Food Influencers</option>
                        <option value="Gaming Influencers">🎮 Gaming Influencers</option>
                        <option value="Tech Influencers">💻 Tech Influencers</option>
                        <option value="Mobile Live Streaming Model">📱 Mobile Live Streaming Model</option>
                        <option value="Music and Performing Arts Influencers">🎵 Music and Performing Arts Influencers</option>
                        <option value="Motivational Speakers and Self-Improvement Influencers">🗣️ Motivational Speakers and Self-Improvement Influencers</option>
                        <option value="Comedy and Entertainment Influencers">😂 Comedy and Entertainment Influencers</option>
                        <option value="Parenting and Family Influencers">👨‍👩‍👧‍👦 Parenting and Family Influencers</option>
                        <option value="Art and Design Influencers">🎨 Art and Design Influencers</option>
                        <option value="Activists and Advocates">✊ Activists and Advocates</option>
                        <option value="Niche Influencers">🎯 Niche Influencers</option>
                        <option value="Night Club Model">🌙 Night Club Model</option>
                        <option value="Party Welcome Model">🎉 Party Welcome Model</option>
                        <option value="Party Waiter Girls">🍸 Party Waiter Girls</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Influencer Type</label>
                    <select id="influencerTypeFilter" class="form-select">
                        <option value="">📊 All Influencer Types</option>
                        <option value="Mega-influencers – with more than a million followers (think celebrities)">🌟 Mega-influencers (1M+ followers)</option>
                        <option value="Macro-influencers – with 500K to 1 million followers">📈 Macro-influencers (500K-1M followers)</option>
                        <option value="Mid-tier influencers – with 50K to 500K followers">📊 Mid-tier influencers (50K-500K followers)</option>
                        <option value="Micro-influencers – with 10K to 50K followers">📱 Micro-influencers (10K-50K followers)</option>
                        <option value="Nano-influencers – with 1K to 10K followers">🔸 Nano-influencers (1K-10K followers)</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Work Type Preference</label>
                    <select id="workTypeFilter" class="form-select">
                        <option value="">🎬 All Work Types</option>
                        <option value="Vlogs (Video Blogs)">📹 Vlogs (Video Blogs)</option>
                        <option value="Tutorials and How-Tos">📚 Tutorials and How-Tos</option>
                        <option value="Product Reviews and Unboxings">📦 Product Reviews and Unboxings</option>
                        <option value="Challenges and Trends">🔥 Challenges and Trends</option>
                        <option value="Q&A Sessions">❓ Q&A Sessions</option>
                        <option value="Brand Collaborations">🤝 Brand Collaborations</option>
                        <option value="Educational and Informative Content">📖 Educational and Informative Content</option>
                        <option value="Entertainment and Comedy Skits">😂 Entertainment and Comedy Skits</option>
                        <option value="Mobile App Live Streams">📱 Mobile App Live Streams</option>
                        <option value="Storytelling and Narratives">📚 Storytelling and Narratives</option>
                        <option value="Event Coverage">🎪 Event Coverage</option>
                        <option value="Fitness and Workout Videos">💪 Fitness and Workout Videos</option>
                        <option value="Short-Form Content (Reels, TikToks, Shorts)">⚡ Short-Form Content (Reels, TikToks, Shorts)</option>
                        <option value="Motivational and Inspirational Videos">🌟 Motivational and Inspirational Videos</option>
                        <option value="Virtual Tours and Experiences">🌐 Virtual Tours and Experiences</option>
                        <option value="1v1 Calling Dating App">💕 1v1 Calling Dating App</option>
                        <option value="Hot Bold Video Content">🔥 Hot Bold Video Content</option>
                        <option value="Bikini Photoshoot">👙 Bikini Photoshoot</option>
                        <option value="Night Club Model girls">🌙 Night Club Model girls</option>
                        <option value="Other">🔄 Other</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Expected Payment Range</label>
                    <select id="paymentRangeFilter" class="form-select">
                        <option value="">💰 All Payment Ranges</option>
                        <option value="Rs 500 to 1000">💰 Rs 500 to 1000</option>
                        <option value="Rs 1k to 2k">💰 Rs 1k to 2k</option>
                        <option value="Rs 2k to 3k">💰 Rs 2k to 3k</option>
                        <option value="Rs 3k to 4k">💰 Rs 3k to 4k</option>
                        <option value="Rs 5k to 10k">💰 Rs 5k to 10k</option>
                        <option value="Rs 10k to 20k">💰 Rs 10k to 20k</option>
                        <option value="Rs 20k to 50k">💰 Rs 20k to 50k</option>
                        <option value="Rs 50k to 70k">💰 Rs 50k to 70k</option>
                        <option value="Rs 70k to 1L">💰 Rs 70k to 1L</option>
                        <option value="Rs 1L +">💎 Rs 1L +</option>
                    </select>
                </div>
            </div>
            
            <!-- Quick Filter Buttons -->
            <div class="quick-filters-section">
                <div class="quick-filters-title">
                    <i class="fas fa-bolt"></i>Quick Filters
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <button class="btn btn-outline-primary btn-quick-filter" onclick="quickFilter('today')">
                        <i class="fas fa-calendar-day me-2"></i>Today's Registrations
                        <?php if ($todayCount > 0): ?>
                            <span class="badge bg-primary ms-2"><?= $todayCount ?></span>
                        <?php endif; ?>
                    </button>
                    <button class="btn btn-outline-warning btn-quick-filter" onclick="quickFilter('pending_today')">
                        <i class="fas fa-clock me-2"></i>Pending Today
                        <?php if ($pendingTodayCount > 0): ?>
                            <span class="badge bg-warning ms-2"><?= $pendingTodayCount ?></span>
                        <?php endif; ?>
                    </button>
                    <button class="btn btn-outline-info btn-quick-filter" onclick="quickFilter('last_24h')">
                        <i class="fas fa-history me-2"></i>Last 24 Hours
                        <?php if ($newCount > 0): ?>
                            <span class="badge bg-info ms-2"><?= $newCount ?></span>
                        <?php endif; ?>
                    </button>
                    <button class="btn filter-reset-btn btn-quick-filter" onclick="clearAllFilters()">
                        <i class="fas fa-refresh me-2"></i>Clear All Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card table-card">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Registrations</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="exportData()">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                    <button class="btn btn-primary btn-sm" onclick="refreshData()">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading registrations...</p>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Professional</th>
                                <th>Category/Role</th>
                                <th>Influencer Info</th>
                                <th>Contact</th>
                                <th>City</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
                
                <div class="empty-state d-none" id="emptyState">
                    <i class="fas fa-inbox"></i>
                    <h5>No registrations found</h5>
                    <p class="text-muted">Try adjusting your filters or search criteria.</p>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" id="paginationContainer">
            <!-- Pagination will be loaded here -->
        </nav>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalTitle">Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="img-fluid rounded" src="" alt="Profile Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registration Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailsModalBody">
                    <!-- Details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Global variables
        let currentPage = 1;
        let totalPages = 1;
        let searchTimeout;
        
        // Initialize charts
        let statusChart, professionalChart;
        
        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            loadData();
            setupEventListeners();
        });
        
        // Initialize charts
        function initializeCharts() {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Approved', 'Rejected'],
                    datasets: [{
                        data: [<?= $pendingCount ?>, <?= $approvedCount ?>, <?= $rejectedCount ?>],
                        backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            
            // Professional Chart
            const professionalCtx = document.getElementById('professionalChart').getContext('2d');
            fetch('get_professional_stats.php')
                .then(response => response.json())
                .then(data => {
                    professionalChart = new Chart(professionalCtx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Registrations',
                                data: data.values,
                                backgroundColor: '#2563eb',
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        }
        
        // Setup event listeners
        function setupEventListeners() {
            // Search input
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    loadData();
                }, 300);
            });
            
            // Filter selects
            ['statusFilter', 'professionalFilter', 'categoryFilter', 'cityFilter', 'dateFilter', 
             'influencerCategoryFilter', 'influencerTypeFilter', 'workTypeFilter', 'paymentRangeFilter'].forEach(id => {
                document.getElementById(id).addEventListener('change', function() {
                    currentPage = 1;
                    loadData();
                });
            });
            
            // Professional filter dependency
            document.getElementById('professionalFilter').addEventListener('change', function() {
                const categoryFilter = document.getElementById('categoryFilter');
                if (this.value !== 'Artist') {
                    categoryFilter.value = '';
                    categoryFilter.disabled = true;
                } else {
                    categoryFilter.disabled = false;
                }
            });
        }
        
        // Load data
        async function loadData() {
            showLoading(true);
            
            try {
                const params = new URLSearchParams({
                    page: currentPage,
                    search: document.getElementById('searchInput').value,
                    status: document.getElementById('statusFilter').value,
                    professional: document.getElementById('professionalFilter').value,
                    category: document.getElementById('categoryFilter').value,
                    city: document.getElementById('cityFilter').value,
                    date_range: document.getElementById('dateFilter').value,
                    influencer_category: document.getElementById('influencerCategoryFilter').value,
                    influencer_type: document.getElementById('influencerTypeFilter').value,
                    work_type: document.getElementById('workTypeFilter').value,
                    payment_range: document.getElementById('paymentRangeFilter').value
                });
                
                const response = await fetch(`fetch_registrations.php?${params}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    displayData(data.clients);
                    updatePagination(data.totalPages, data.page);
                } else {
                    showAlert('Error loading data: ' + data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error loading data. Please try again.', 'danger');
            } finally {
                showLoading(false);
            }
        }
        
        // Display data in table
        function displayData(clients) {
            const tbody = document.getElementById('dataTableBody');
            const emptyState = document.getElementById('emptyState');
            
            if (clients.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('d-none');
                return;
            }
            
            emptyState.classList.add('d-none');
            
            tbody.innerHTML = clients.map(client => {
                const registrationTime = getRegistrationTimeInfo(client.created_at);
                const rowClass = registrationTime.isNew ? 'new-registration' : (registrationTime.isToday ? 'new-today' : '');
                
                return `
                <tr class="${rowClass}">
                    <td>
                        <div class="position-relative">
                            <img src="${formatImageUrl(client.image_url)}" 
                                 alt="Profile" 
                                 class="profile-img"
                                 onclick="showImageModal('${formatImageUrl(client.image_url)}', '${client.name}')">
                            ${registrationTime.isNew ? '<span class="badge badge-new position-absolute top-0 start-100 translate-middle">NEW</span>' : ''}
                            ${registrationTime.isToday && !registrationTime.isNew ? '<span class="badge badge-today position-absolute top-0 start-100 translate-middle">TODAY</span>' : ''}
                        </div>
                    </td>
                    <td>
                        <div>
                            <div class="fw-semibold">
                                ${client.name}
                                ${registrationTime.isNew ? '<i class="fas fa-star text-warning ms-1" title="New Registration"></i>' : ''}
                            </div>
                            <small class="text-muted">${client.age} years, ${client.gender}</small>
                        </div>
                    </td>
                    <td>
                        <span class="badge ${client.professional === 'Artist' ? 'badge-artist' : 'badge-employee'}">
                            ${client.professional}
                        </span>
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 150px;" title="${client.professional === 'Artist' ? (client.category || '-') : (client.role || '-')}">
                            ${client.professional === 'Artist' ? (client.category || '-') : (client.role || '-')}
                        </div>
                    </td>
                    <td>
                        ${client.professional === 'Artist' ? `
                            <div class="influencer-info">
                                ${client.influencer_category ? `
                                    <div class="info-item">
                                        <i class="fas fa-tag text-primary"></i>
                                        <span class="info-text">${getShortCategory(client.influencer_category)}</span>
                                    </div>
                                ` : ''}
                                ${client.influencer_type ? `
                                    <div class="info-item">
                                        <i class="fas fa-users text-info"></i>
                                        <span class="info-text">${getShortInfluencerType(client.influencer_type)}</span>
                                    </div>
                                ` : ''}
                                ${client.expected_payment ? `
                                    <div class="info-item">
                                        <i class="fas fa-rupee-sign text-success"></i>
                                        <span class="info-text text-success fw-bold">${getShortPayment(client.expected_payment)}</span>
                                    </div>
                                ` : ''}
                                ${client.work_type_preference ? `
                                    <div class="info-item">
                                        <i class="fas fa-video text-warning"></i>
                                        <span class="info-text">${getShortWorkType(client.work_type_preference)}</span>
                                    </div>
                                ` : ''}
                            </div>
                        ` : `
                            <div class="text-center">
                                <i class="fas fa-briefcase text-muted"></i>
                                <div class="small text-muted">Employee</div>
                            </div>
                        `}
                    </td>
                    <td>
                        <div>
                            ${client.phone ? `
                                <a href="https://wa.me/91${client.phone}" target="_blank" class="whatsapp-link">
                                    <i class="fab fa-whatsapp me-1"></i>${client.phone}
                                </a>
                            ` : '<span class="text-muted">No phone</span>'}
                        </div>
                        ${client.email ? `<small class="text-muted">${client.email}</small>` : ''}
                    </td>
                    <td>${client.city || '-'}</td>
                    <td>
                        <span class="badge badge-${client.approval_status}">
                            ${client.approval_status.charAt(0).toUpperCase() + client.approval_status.slice(1)}
                        </span>
                    </td>
                    <td>
                        <div class="time-indicator ${registrationTime.isNew ? 'time-new' : (registrationTime.isToday ? 'time-today' : '')}">
                            ${registrationTime.display}
                        </div>
                        <small class="text-muted">${formatDate(client.created_at)}</small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-action btn-view" onclick="showDetails(${client.id})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${client.approval_status === 'pending' ? `
                                <button class="btn btn-action btn-approve" onclick="approveClient(${client.id})" title="Approve Registration">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-action btn-reject" onclick="rejectClient(${client.id})" title="Reject Registration">
                                    <i class="fas fa-times"></i>
                                </button>
                            ` : `
                                <button class="btn btn-action btn-edit" onclick="editClient(${client.id})" title="Edit Details">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-action btn-visibility ${client.is_visible ? 'btn-hide' : 'btn-show'}" onclick="toggleVisibility(${client.id}, ${client.is_visible})" title="${client.is_visible ? 'Hide from Public' : 'Show to Public'}">
                                    <i class="fas fa-${client.is_visible ? 'eye' : 'eye-slash'}"></i>
                                </button>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-action btn-more" type="button" data-bs-toggle="dropdown" title="More Actions">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="https://wa.me/91${client.phone}" target="_blank">
                                            <i class="fab fa-whatsapp text-success me-2"></i>WhatsApp
                                        </a></li>
                                        ${client.instagram_profile ? `
                                            <li><a class="dropdown-item" href="${client.instagram_profile}" target="_blank">
                                                <i class="fab fa-instagram text-danger me-2"></i>Instagram
                                            </a></li>
                                        ` : ''}
                                        ${client.resume_url ? `
                                            <li><a class="dropdown-item" href="../${client.resume_url}" target="_blank">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>Resume
                                            </a></li>
                                        ` : ''}
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteClient(${client.id})">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </a></li>
                                    </ul>
                                </div>
                            `}
                        </div>
                    </td>
                </tr>
            `;
            }).join('');
        }
        
        // Update pagination
        function updatePagination(total, current) {
            totalPages = total;
            currentPage = current;
            
            const container = document.getElementById('paginationContainer');
            
            if (total <= 1) {
                container.innerHTML = '';
                return;
            }
            
            let paginationHtml = '<ul class="pagination">';
            
            // Previous button
            if (current > 1) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${current - 1})">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                `;
            }
            
            // Page numbers
            const startPage = Math.max(1, current - 2);
            const endPage = Math.min(total, startPage + 4);
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `
                    <li class="page-item ${i === current ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            }
            
            // Next button
            if (current < total) {
                paginationHtml += `
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="changePage(${current + 1})">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                `;
            }
            
            paginationHtml += '</ul>';
            container.innerHTML = paginationHtml;
        }
        
        // Change page
        function changePage(page) {
            currentPage = page;
            loadData();
        }
        
        // Show loading state
        function showLoading(show) {
            const spinner = document.getElementById('loadingSpinner');
            const table = document.querySelector('.table-responsive');
            
            if (show) {
                spinner.style.display = 'block';
                table.style.opacity = '0.5';
            } else {
                spinner.style.display = 'none';
                table.style.opacity = '1';
            }
        }
        
        // Show alert
        function showAlert(message, type = 'success') {
            const container = document.getElementById('alertContainer');
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            container.innerHTML = alertHtml;
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
        
        // Format image URL
        function formatImageUrl(url) {
            if (!url) return '/images/default-avatar.png';
            if (url.startsWith('http')) return url;
            return '../' + url;
        }
        
        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        // Show image modal
        function showImageModal(src, name) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModalTitle').textContent = name + ' - Profile Image';
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }
        
        // Show details modal
        async function showDetails(id) {
            try {
                const response = await fetch(`get_client_details.php?id=${id}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    const client = data.client;
                    const modalBody = document.getElementById('detailsModalBody');
                    
                    modalBody.innerHTML = `
                        <div class="row">
                            <div class="col-md-3 text-center mb-4">
                                <img src="${formatImageUrl(client.image_url)}" alt="Profile" class="img-fluid rounded mb-3" style="max-width: 150px;">
                                <h5 class="mb-2">${client.name}</h5>
                                <span class="badge badge-${client.approval_status} mb-2">${client.approval_status.charAt(0).toUpperCase() + client.approval_status.slice(1)}</span>
                                <p class="text-muted small mb-0">${client.age} years, ${client.gender}</p>
                                <p class="text-muted small">${client.city || 'City not specified'}</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">PROFESSIONAL TYPE</label>
                                        <p class="mb-0">${client.professional}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">${client.professional === 'Artist' ? 'CATEGORY' : 'ROLE'}</label>
                                        <p class="mb-0">${client.professional === 'Artist' ? (client.category || '-') : (client.role || '-')}</p>
                                    </div>
                                    ${client.phone ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">PHONE</label>
                                            <p class="mb-0">
                                                <a href="https://wa.me/91${client.phone}" target="_blank" class="text-success text-decoration-none">
                                                    <i class="fab fa-whatsapp me-1"></i>${client.phone}
                                                </a>
                                            </p>
                                        </div>
                                    ` : ''}
                                    ${client.email ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">EMAIL</label>
                                            <p class="mb-0">
                                                <a href="mailto:${client.email}" class="text-primary text-decoration-none">
                                                    ${client.email}
                                                </a>
                                            </p>
                                        </div>
                                    ` : ''}
                                    ${client.experience ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">EXPERIENCE</label>
                                            <p class="mb-0">${client.experience}</p>
                                        </div>
                                    ` : ''}
                                    ${client.language ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">LANGUAGES</label>
                                            <p class="mb-0">${client.language}</p>
                                        </div>
                                    ` : ''}
                                    ${client.current_salary ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">CURRENT SALARY</label>
                                            <p class="mb-0 text-success fw-bold">${client.current_salary}</p>
                                        </div>
                                    ` : ''}
                                    ${client.influencer_category ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">INFLUENCER CATEGORY</label>
                                            <p class="mb-0">${client.influencer_category}</p>
                                        </div>
                                    ` : ''}
                                    ${client.influencer_type ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">INFLUENCER TYPE</label>
                                            <p class="mb-0">${client.influencer_type}</p>
                                        </div>
                                    ` : ''}
                                    ${client.expected_payment ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">EXPECTED PAYMENT</label>
                                            <p class="mb-0 text-success fw-bold">₹${client.expected_payment}</p>
                                        </div>
                                    ` : ''}
                                    ${client.work_type_preference ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">WORK TYPE PREFERENCE</label>
                                            <p class="mb-0">${client.work_type_preference}</p>
                                        </div>
                                    ` : ''}
                                    ${client.followers ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">FOLLOWERS</label>
                                            <p class="mb-0">${client.followers}</p>
                                        </div>
                                    ` : ''}
                                    ${client.instagram_profile ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">INSTAGRAM</label>
                                            <p class="mb-0">
                                                <a href="${client.instagram_profile}" target="_blank" class="text-danger text-decoration-none">
                                                    <i class="fab fa-instagram me-1"></i>View Profile
                                                </a>
                                            </p>
                                        </div>
                                    ` : ''}
                                    ${client.resume_url ? `
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">RESUME</label>
                                            <p class="mb-0">
                                                <a href="../${client.resume_url}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-download me-1"></i>Download
                                                </a>
                                            </p>
                                        </div>
                                    ` : ''}
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">REGISTRATION DATE</label>
                                        <p class="mb-0">${formatDate(client.created_at)}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    new bootstrap.Modal(document.getElementById('detailsModal')).show();
                } else {
                    showAlert('Error loading details: ' + data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error loading details. Please try again.', 'danger');
            }
        }
        
        // Client actions
        async function approveClient(id) {
            if (!confirm('Are you sure you want to approve this registration?')) return;
            
            try {
                const response = await fetch(`approve_client.php?id=${id}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    showAlert('Registration approved successfully!');
                    loadData();
                    // Update charts
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error approving registration. Please try again.', 'danger');
            }
        }
        
        async function rejectClient(id) {
            if (!confirm('Are you sure you want to reject this registration?')) return;
            
            try {
                const response = await fetch(`reject_client.php?id=${id}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    showAlert('Registration rejected successfully!');
                    loadData();
                    // Update charts
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error rejecting registration. Please try again.', 'danger');
            }
        }
        
        function editClient(id) {
            window.location.href = `edit_client_form.php?id=${id}`;
        }
        
        async function toggleVisibility(id, currentVisibility) {
            try {
                // Show loading state
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                const originalClass = button.className;
                
                button.classList.add('loading');
                button.innerHTML = '<i class="fas fa-spinner"></i>';
                button.disabled = true;
                
                const response = await fetch(`toggle_visibility.php?id=${id}`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    // Update the button immediately without full reload
                    const newVisibility = data.is_visible;
                    const newTitle = newVisibility ? 'Hide from Public' : 'Show to Public';
                    const newIcon = newVisibility ? 'eye' : 'eye-slash';
                    
                    // Update button class and content
                    button.className = originalClass.replace('loading', '').replace('btn-hide', '').replace('btn-show', '');
                    button.classList.add(newVisibility ? 'btn-hide' : 'btn-show');
                    button.innerHTML = `<i class="fas fa-${newIcon}"></i>`;
                    button.title = newTitle;
                    button.onclick = () => toggleVisibility(id, newVisibility);
                    
                    showAlert(`Client ${newVisibility ? 'shown to public' : 'hidden from public'} successfully!`);
                } else {
                    // Restore original button state on error
                    button.className = originalClass;
                    button.innerHTML = originalHTML;
                    showAlert('Error: ' + data.message, 'danger');
                }
                
                button.disabled = false;
            } catch (error) {
                console.error('Error:', error);
                // Restore original button state on error
                const button = event.target.closest('button');
                button.className = originalClass;
                button.innerHTML = originalHTML;
                button.disabled = false;
                showAlert('Error updating visibility. Please try again.', 'danger');
            }
        }

        async function deleteClient(id) {
            if (!confirm('Are you sure you want to permanently delete this registration? This action cannot be undone.')) return;
            
            try {
                const response = await fetch(`delete_client.php?id=${id}`, {
                    method: 'POST'
                });
                const data = await response.json();
                
                if (data.status === 'success') {
                    showAlert('Registration deleted successfully!');
                    loadData();
                    // Update charts
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    showAlert('Error: ' + data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error deleting registration. Please try again.', 'danger');
            }
        }
        
        // Helper functions to shorten text for better display
        function getShortCategory(category) {
            const shortNames = {
                'Video Content Creators': 'Video Creator',
                'Fashion Influencers': 'Fashion',
                'Beauty Model for shooting': 'Beauty Model',
                'Fitness and Health Influencers': 'Fitness',
                'Lifestyle Influencers': 'Lifestyle',
                'Travel Influencers': 'Travel',
                'Food Influencers': 'Food',
                'Gaming Influencers': 'Gaming',
                'Tech Influencers': 'Tech',
                'Mobile Live Streaming Model': 'Live Stream',
                'Music and Performing Arts Influencers': 'Music/Arts',
                'Motivational Speakers and Self-Improvement Influencers': 'Motivational',
                'Comedy and Entertainment Influencers': 'Comedy',
                'Parenting and Family Influencers': 'Family',
                'Art and Design Influencers': 'Art/Design',
                'Activists and Advocates': 'Activist',
                'Niche Influencers': 'Niche',
                'Night Club Model': 'Night Club',
                'Party Welcome Model': 'Party Model',
                'Party Waiter Girls': 'Party Waiter'
            };
            return shortNames[category] || category;
        }

        function getShortInfluencerType(type) {
            const shortNames = {
                'Mega-influencers – with more than a million followers (think celebrities)': 'Mega (1M+)',
                'Macro-influencers – with 500K to 1 million followers': 'Macro (500K-1M)',
                'Mid-tier influencers – with 50K to 500K followers': 'Mid-tier (50K-500K)',
                'Micro-influencers – with 10K to 50K followers': 'Micro (10K-50K)',
                'Nano-influencers – with 1K to 10K followers': 'Nano (1K-10K)'
            };
            return shortNames[type] || type;
        }

        function getShortPayment(payment) {
            // Remove "Rs " prefix if present and return clean format
            return payment.replace('Rs ', '');
        }

        function getShortWorkType(workType) {
            const shortNames = {
                'Vlogs (Video Blogs)': 'Vlogs',
                'Tutorials and How-Tos': 'Tutorials',
                'Product Reviews and Unboxings': 'Reviews',
                'Challenges and Trends': 'Challenges',
                'Q&A Sessions': 'Q&A',
                'Brand Collaborations': 'Brand Collab',
                'Educational and Informative Content': 'Educational',
                'Entertainment and Comedy Skits': 'Comedy',
                'Mobile App Live Streams': 'Live Streams',
                'Storytelling and Narratives': 'Storytelling',
                'Event Coverage': 'Events',
                'Fitness and Workout Videos': 'Fitness',
                'Short-Form Content (Reels, TikToks, Shorts)': 'Short-Form',
                'Motivational and Inspirational Videos': 'Motivational',
                'Virtual Tours and Experiences': 'Virtual Tours',
                '1v1 Calling Dating App': '1v1 Dating',
                'Hot Bold Video Content': 'Bold Content',
                'Bikini Photoshoot': 'Bikini Shoot',
                'Night Club Model girls': 'Night Club',
                'Other': 'Other'
            };
            return shortNames[workType] || workType;
        }

        // Get registration time information
        function getRegistrationTimeInfo(createdAt) {
            const now = new Date();
            const registrationDate = new Date(createdAt);
            const diffInHours = (now - registrationDate) / (1000 * 60 * 60);
            const diffInDays = Math.floor(diffInHours / 24);
            
            const isNew = diffInHours <= 2; // New if registered within 2 hours
            const isToday = diffInDays === 0 && !isNew;
            
            let display = '';
            if (isNew) {
                const minutes = Math.floor((now - registrationDate) / (1000 * 60));
                if (minutes < 60) {
                    display = `${minutes}m ago`;
                } else {
                    display = `${Math.floor(minutes / 60)}h ago`;
                }
            } else if (isToday) {
                display = 'Today';
            } else if (diffInDays === 1) {
                display = 'Yesterday';
            } else if (diffInDays < 7) {
                display = `${diffInDays} days ago`;
            } else {
                display = formatDate(createdAt).split(',')[0]; // Just the date part
            }
            
            return { isNew, isToday, display };
        }
        
        // Quick filter functions
        function quickFilter(type) {
            // Remove active class from all quick filter buttons
            document.querySelectorAll('.btn-outline-primary, .btn-outline-warning, .btn-outline-info').forEach(btn => {
                btn.classList.remove('quick-filter-active');
            });
            
            // Clear all filters first
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('professionalFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('cityFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('influencerCategoryFilter').value = '';
            document.getElementById('influencerTypeFilter').value = '';
            document.getElementById('workTypeFilter').value = '';
            document.getElementById('paymentRangeFilter').value = '';
            
            // Apply specific filter
            switch(type) {
                case 'today':
                    document.getElementById('dateFilter').value = 'today';
                    event.target.classList.add('quick-filter-active');
                    break;
                case 'pending_today':
                    document.getElementById('dateFilter').value = 'today';
                    document.getElementById('statusFilter').value = 'pending';
                    event.target.classList.add('quick-filter-active');
                    break;
                case 'last_24h':
                    document.getElementById('dateFilter').value = 'last_24h';
                    event.target.classList.add('quick-filter-active');
                    break;
            }
            
            currentPage = 1;
            loadData();
        }
        
        function clearAllFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('professionalFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('cityFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('influencerCategoryFilter').value = '';
            document.getElementById('influencerTypeFilter').value = '';
            document.getElementById('workTypeFilter').value = '';
            document.getElementById('paymentRangeFilter').value = '';
            
            // Remove active class from all quick filter buttons
            document.querySelectorAll('.quick-filter-active').forEach(btn => {
                btn.classList.remove('quick-filter-active');
            });
            
            currentPage = 1;
            loadData();
        }
        
        // Utility functions
        function refreshData() {
            loadData();
        }
        
        function exportData() {
            const params = new URLSearchParams({
                export: 'csv',
                search: document.getElementById('searchInput').value,
                status: document.getElementById('statusFilter').value,
                professional: document.getElementById('professionalFilter').value,
                category: document.getElementById('categoryFilter').value,
                city: document.getElementById('cityFilter').value,
                date_range: document.getElementById('dateFilter').value,
                influencer_category: document.getElementById('influencerCategoryFilter').value,
                influencer_type: document.getElementById('influencerTypeFilter').value,
                work_type: document.getElementById('workTypeFilter').value,
                payment_range: document.getElementById('paymentRangeFilter').value
            });
            
            window.open(`export_registrations.php?${params}`, '_blank');
        }
    </script>
</body>
</html> 