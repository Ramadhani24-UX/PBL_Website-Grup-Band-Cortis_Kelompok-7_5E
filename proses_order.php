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
$customer_email   = trim($_POST['customer_email'] ?? '');
$customer_phone   = trim($_POST['customer_phone'] ?? '');
$shipping_address = trim($_POST['shipping_address'] ?? '');

// 2. Validasi kelengkapan input dasar
if ($product_id <= 0 || $variation_id <= 0 || $quantity <= 0 || empty($customer_name) || empty($customer_email) || empty($customer_phone) || empty($shipping_address)) {
    $msg = urlencode('Harap lengkapi seluruh data pemesanan dengan benar.');
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}

// 3. Cek harga produk & ketersediaan stok variasi di database
$q_cek = mysqli_query($conn, "
    SELECT p.price, p.product_name, v.stock 
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
$stok_tersedia = (int) $data_item['stock'];

if ($quantity > $stok_tersedia) {
    $msg = urlencode("Stok tidak mencukupi. Sisa stok tersedia: $stok_tersedia.");
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}

// 4. Hitung total & buat kode transaksi unik
$subtotal         = $unit_price * $quantity;
$total_amount     = $subtotal;
$transaction_code = 'CRT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

// 5. Jalankan transaksi database (ACID) agar data konsisten
mysqli_begin_transaction($conn);

try {
    $esc_code    = mysqli_real_escape_string($conn, $transaction_code);
    $esc_name    = mysqli_real_escape_string($conn, $customer_name);
    $esc_email   = mysqli_real_escape_string($conn, $customer_email);
    $esc_phone   = mysqli_real_escape_string($conn, $customer_phone);
    $esc_address = mysqli_real_escape_string($conn, $shipping_address);
    $esc_payment = mysqli_real_escape_string($conn, $payment_method);

    // Simpan ke tabel transactions
    $sql_trx = "
        INSERT INTO transactions (transaction_code, customer_name, customer_email, customer_phone, shipping_address, total_amount, payment_method, status)
        VALUES ('$esc_code', '$esc_name', '$esc_email', '$esc_phone', '$esc_address', $total_amount, '$esc_payment', 'Pending')
    ";
    if (!mysqli_query($conn, $sql_trx)) {
        throw new Exception('Gagal menyimpan data transaksi utama.');
    }

    $transaction_id = mysqli_insert_id($conn);

    // Simpan ke tabel transaction_details
    $sql_detail = "
        INSERT INTO transaction_details (transaction_id, product_id, variation_id, quantity, unit_price, subtotal)
        VALUES ($transaction_id, $product_id, $variation_id, $quantity, $unit_price, $subtotal)
    ";
    if (!mysqli_query($conn, $sql_detail)) {
        throw new Exception('Gagal menyimpan rincian item pesanan.');
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

    // Redirect kembali ke Store.php dengan status sukses
    header("Location: Store.php?status=success&code=" . urlencode($transaction_code));
    exit;

} catch (Exception $e) {
    mysqli_rollback($conn);
    $msg = urlencode($e->getMessage());
    header("Location: Store.php?status=error&msg=$msg");
    exit;
}
?>