<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CORTIS Admin CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a1a; color: #fff; }
        .sidebar { min-height: 100vh; background-color: #2b2b2b; padding-top: 20px; border-right: 1px solid #444; }
        .sidebar a { color: #ccc; text-decoration: none; padding: 12px 20px; display: block; border-left: 4px solid transparent; font-weight: 500; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background-color: #333; border-left: 4px solid #00bac6; color: #00bac6; }
        .card { background-color: #2b2b2b; color: #fff; border: 1px solid #444; border-radius: 10px; }
        .table { color: #fff; }
        .table-striped tbody tr:nth-of-type(odd) { background-color: rgba(255,255,255,0.05); color: #fff; }
        .table-striped tbody tr:nth-of-type(even) { background-color: transparent; color: #fff; }
        .table-bordered td, .table-bordered th { border-color: #444; }
        .form-control, .form-select { background-color: #333; color: #fff; border: 1px solid #555; }
        .form-control:focus, .form-select:focus { background-color: #444; color: #fff; border-color: #00bac6; box-shadow: 0 0 0 0.25rem rgba(0, 186, 198, 0.25); }
        .btn-primary { background-color: #00bac6; border-color: #00bac6; color: #1a1a1a; font-weight: bold; }
        .btn-primary:hover { background-color: #009aa3; border-color: #009aa3; color: #1a1a1a; }
        .text-accent { color: #00bac6; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <h4 class="text-center mb-4 mt-3 text-accent fw-bold">CORTIS CRUD</h4>
            <a href="index.php">Dashboard</a>
            <a href="group_profile_read.php">Group Profile</a>
            <a href="member_profile_read.php">Member Profile</a>
            <a href="albums_read.php">Albums</a>
            <a href="gallery_read.php">Gallery</a>
            <a href="products_read.php">Products</a>
            <a href="transactions_read.php">Transactions</a>
            <a href="tracks_read.php">Tracks</a>
            <a href="product_variations_read.php">Product Variations</a>
            <a href="transaction_details_read.php">Transaction Details</a>
        </div>
        <div class="col-md-10 p-4">
