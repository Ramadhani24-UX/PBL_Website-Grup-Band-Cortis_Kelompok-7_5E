<?php
// Mendeteksi halaman yang sedang dibuka agar menu sidebar menyala (active)
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORTIS Admin CRUD</title>
    
    <!-- CSS AdminLTE v4 -->
    <link rel="stylesheet" href="adminlte/css/adminlte.min.css">
    <!-- Font Awesome untuk Ikon Menu -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Style CORTIS -->
    <style>
        :root {
            --cortis-accent: #00bac6;
            --cortis-accent-hover: #009aa3;
        }
        .text-accent { color: var(--cortis-accent) !important; }
        .btn-primary { 
            background-color: var(--cortis-accent); 
            border-color: var(--cortis-accent); 
            color: #1a1a1a; 
            font-weight: bold; 
        }
        .btn-primary:hover { 
            background-color: var(--cortis-accent-hover); 
            border-color: var(--cortis-accent-hover); 
            color: #1a1a1a; 
        }
        .sidebar-menu .nav-link.active {
            background-color: rgba(0, 186, 198, 0.15) !important;
            color: var(--cortis-accent) !important;
            border-left: 4px solid var(--cortis-accent);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--cortis-accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 186, 198, 0.25);
        }

        /* Pengaturan Tabel Global: Semua judul kolom (th) rata tengah, garis & warna abu penuh */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        table th {
            text-align: center !important;
            vertical-align: middle !important;
        }
        table th:last-child:not([colspan]), 
        table td:last-child:not([colspan]) {
            text-align: center !important;
            vertical-align: middle !important;
            white-space: nowrap !important;
            width: 1%;
        }
        table td:last-child:not([colspan]) .btn,
        table td:last-child:not([colspan]) a {
            display: inline-block;
            margin: 0 2px;
        }

        /* Membuat tulisan CORTIS ADMIN CRUD tepat di tengah-tengah kotak (horizontal & vertikal) */
        .sidebar-brand {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
            width: 100% !important;
            text-align: center !important;
        }
        .sidebar-brand .brand-link {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .sidebar-brand .brand-text {
            margin: 0 !important;
            padding: 0 !important;
            text-align: center !important;
        }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- NAVBAR ATAS -->
    <nav class="app-header navbar navbar-expand bg-body border-bottom">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link text-accent fw-bold">CORTIS Management System</span>
                </li>
            </ul>
        </div>
    </nav>

    <!-- SIDEBAR KIRI (10 Menu Lengkap CORTIS) -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand border-bottom">
            <a href="index.php" class="brand-link text-decoration-none">
                <span class="brand-text fw-bold text-accent">CORTIS ADMIN CRUD</span>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-item">
                        <a href="index.php" class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase text-muted fs-7 mt-2">Band Profile</li>
                    <li class="nav-item">
                        <a href="group_profile_read.php" class="nav-link <?= (strpos($current_page, 'group_profile') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Group Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="member_profile_read.php" class="nav-link <?= (strpos($current_page, 'member_profile') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-astronaut"></i>
                            <p>Member Profile</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase text-muted fs-7 mt-2">Discography & Media</li>
                    <li class="nav-item">
                        <a href="albums_read.php" class="nav-link <?= (strpos($current_page, 'albums') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-compact-disc"></i>
                            <p>Albums</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="tracks_read.php" class="nav-link <?= (strpos($current_page, 'tracks') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-music"></i>
                            <p>Tracks</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="gallery_read.php" class="nav-link <?= (strpos($current_page, 'gallery') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Gallery</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase text-muted fs-7 mt-2">Merchandise Store</li>
                    <li class="nav-item">
                        <a href="products_read.php" class="nav-link <?= (strpos($current_page, 'products_') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tshirt"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="product_variations_read.php" class="nav-link <?= (strpos($current_page, 'product_variations') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Product Variations</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="transactions_read.php" class="nav-link <?= (strpos($current_page, 'transactions_') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Transactions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="transaction_details_read.php" class="nav-link <?= (strpos($current_page, 'transaction_details') !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Transaction Details</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- PEMBUKA AREA KONTEN UTAMA ADMINLTE -->
    <main class="app-main">
        <div class="app-content pt-4">
            <div class="container-fluid">