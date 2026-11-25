<?php
require_once 'Admin/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Store.php');
    exit;
}

// 1. Ambil & bersihkan input dari form modal Store.php
$product_id       = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
$variation_id     = isset($_POST['variation_id']) ? (int) $_POST['variation_id'] : 0;
$quantity         = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
$payment_method   = trim($_POST['payment_method'] ?? '');
$customer_name    = trim($_POST['customer_name'] ?? '');
$customer_phone   = trim($_POST['customer_phone'] ?? '');
$shipping_address = trim($_POST['shipping_address'] ?? '');

// 2. Validasi kelengkapan input dasar
if ($product_id <= 0 || $variation_id <= 0 || $quantity <= 0 || empty($customer_name) || empty($customer_phone) || empty($shipping_address)) {
    $msg = urlencode('Harap lengkapi seluruh data pemesanan dengan benar.');
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}

// 3. Cek harga produk, berat produk & ketersediaan stok variasi di database
$q_cek = mysqli_query($conn, "
    SELECT p.price, p.product_name, p.weight_gram, v.stock 
    FROM products p 
    INNER JOIN product_variations v ON p.product_id = v.product_id 
    WHERE p.product_id = $product_id AND v.variation_id = $variation_id 
    LIMIT 1
");

if (!$q_cek || mysqli_num_rows($q_cek) === 0) {
    $msg = urlencode('Produk atau variasi yang dipilih tidak ditemukan.');
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}

$data_item     = mysqli_fetch_assoc($q_cek);
$unit_price    = (float) $data_item['price'];
$weight_gram   = (int) ($data_item['weight_gram'] ?? 0);
$stok_tersedia = (int) $data_item['stock'];

if ($quantity > $stok_tersedia) {
    $msg = urlencode("Stok tidak mencukupi. Sisa stok tersedia: $stok_tersedia.");
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}

// 4. Hitung total harga, total berat & set nilai default pengiriman
$subtotal_price   = $unit_price * $quantity;
$shipping_cost    = 0;
$grand_total      = $subtotal_price + $shipping_cost;
$total_weight     = $weight_gram * $quantity;
$courier_service  = 'Standard Delivery';
$transaction_date = date('Y-m-d H:i:s');

// 5. Jalankan transaksi database (ACID) agar data konsisten
mysqli_begin_transaction($conn);

try {
    $esc_name    = mysqli_real_escape_string($conn, $customer_name);
    $esc_phone   = mysqli_real_escape_string($conn, $customer_phone);
    $esc_address = mysqli_real_escape_string($conn, $shipping_address);
    $esc_courier = mysqli_real_escape_string($conn, $courier_service);
    $esc_payment = mysqli_real_escape_string($conn, $payment_method);

    // Simpan ke tabel transactions (sesuai struktur asli tabel transactions)
    $sql_trx = "
        INSERT INTO transactions (
            customer_name, 
            customer_phone, 
            shipping_address, 
            courier_service, 
            shipping_cost, 
            payment_method, 
            total_weight, 
            grand_total, 
            transaction_date, 
            status
        ) VALUES (
            '$esc_name', 
            '$esc_phone', 
            '$esc_address', 
            '$esc_courier', 
            $shipping_cost, 
            '$esc_payment', 
            $total_weight, 
            $grand_total, 
            '$transaction_date', 
            'Pending'
        )
    ";
    if (!mysqli_query($conn, $sql_trx)) {
        throw new Exception('Gagal menyimpan transaksi: ' . mysqli_error($conn));
    }

    $transaction_id = mysqli_insert_id($conn);

    // Simpan ke tabel transaction_details (sesuai struktur asli tabel transaction_details)
    $sql_detail = "
        INSERT INTO transaction_details (
            transaction_id, 
            variation_id, 
            quantity, 
            subtotal_price
        ) VALUES (
            $transaction_id, 
            $variation_id, 
            $quantity, 
            $subtotal_price
        )
    ";
    if (!mysqli_query($conn, $sql_detail)) {
        throw new Exception('Gagal menyimpan rincian pesanan: ' . mysqli_error($conn));
    }

    // Kurangi stok pada tabel product_variations
    $sql_update_stok = "
        UPDATE product_variations 
        SET stock = stock - $quantity 
        WHERE variation_id = $variation_id AND stock >= $quantity
    ";
    if (!mysqli_query($conn, $sql_update_stok) || mysqli_affected_rows($conn) === 0) {
        throw new Exception('Gagal memperbarui stok variasi produk.');
    }

    mysqli_commit($conn);

    // Buat kode tampilan transaksi dari transaction_id yang baru tersimpan
    $display_code = 'CRT-' . date('Ymd') . '-' . str_pad($transaction_id, 4, '0', STR_PAD_LEFT);

    // Redirect kembali ke Store.php dengan status sukses
    header("Location: Store.php?status=success&code=" . urlencode($display_code));
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    $msg = urlencode($e->getMessage());
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}
?>