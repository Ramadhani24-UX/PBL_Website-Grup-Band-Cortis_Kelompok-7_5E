<?php
require_once 'Admin/connection.php';

function resolveImagePath($path, $default) {
    if (empty($path)) return $default;
    if (file_exists($path)) return $path;
    if (file_exists('Assets/images/' . $path)) return 'Assets/images/' . $path;
    if (file_exists('Admin/' . $path)) return 'Admin/' . $path;
    if (file_exists('Admin/uploads/' . $path)) return 'Admin/uploads/' . $path;
    return $default;
}

// 1. Ambil seluruh data produk dari tabel products
$products_map = [];
$products_list = [];
$q_products = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id ASC");
if ($q_products) {
    while ($p = mysqli_fetch_assoc($q_products)) {
        $pid = (int) $p['product_id'];
        $p['resolved_image'] = resolveImagePath($p['image_path'], 'Assets/images/tshirt.png');
        $products_map[$pid] = $p;
        $products_list[] = $p;
    }
}

// 2. Ambil seluruh variasi produk dari tabel product_variations beserta gambarnya masing-masing
$variations_by_product = [];
$total_stock_by_product = [];
$q_vars = mysqli_query($conn, "SELECT * FROM product_variations ORDER BY variation_id ASC");
if ($q_vars) {
    while ($v = mysqli_fetch_assoc($q_vars)) {
        $pid = (int) $v['product_id'];
        $fallback_img = isset($products_map[$pid]) ? $products_map[$pid]['resolved_image'] : 'Assets/images/tshirt.png';
        $var_img = resolveImagePath($v['image_path'] ?? '', $fallback_img);

        $variations_by_product[$pid][] = [
            'variation_id' => (int) $v['variation_id'],
            'size'         => $v['size'],
            'color'        => $v['color'],
            'gender_type'  => $v['gender_type'],
            'stock'        => (int) $v['stock'],
            'image_path'   => $var_img
        ];
        if (!isset($total_stock_by_product[$pid])) {
            $total_stock_by_product[$pid] = 0;
        }
        $total_stock_by_product[$pid] += (int) $v['stock'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORTIS - Official Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background-color: #0e1015;
            color: #ffffff;
            line-height: 1.6;
        }

        /* --- Navbar --- */
        header {
            background: linear-gradient(to right, #1a1a1a 20%, #005f6b 65%, #008080 100%);
            padding: 15px 40px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo {
            height: 48px;
            border-radius: 8px;
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 24px;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 28px;
        }

        nav ul li a {
            color: #e0e0e0;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            transition: color 0.25s;
        }

        nav ul li a:hover,
        nav ul li a.active {
            color: #ffffff;
            border-bottom: 3px solid #00bac6;
            padding-bottom: 4px;
        }

        /* --- Hero Header --- */
        .store-hero {
            text-align: center;
            padding: 60px 20px 40px;
            background: radial-gradient(circle at top, rgba(0, 186, 198, 0.2), transparent 65%);
        }

        .store-hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: 3.2rem;
            margin: 0 0 10px;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .store-hero p {
            color: #b8c0cc;
            font-size: 1.15rem;
            max-width: 650px;
            margin: 0 auto;
        }

        /* --- Status Alert --- */
        .alert-banner {
            max-width: 1140px;
            margin: 0 auto 25px;
            padding: 15px 22px;
            border-radius: 10px;
            font-weight: 600;
            text-align: center;
        }

        .alert-success {
            background-color: rgba(0, 186, 198, 0.18);
            border: 1px solid #00bac6;
            color: #7ef9ff;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.18);
            border: 1px solid #ef4444;
            color: #fca5a5;
        }

        /* --- Product Grid --- */
        .store-container {
            max-width: 1180px;
            margin: 0 auto 80px;
            padding: 0 24px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .product-card {
            background-color: #161922;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: #00bac6;
            box-shadow: 0 12px 28px rgba(0, 186, 198, 0.22);
        }

        .product-img-wrap {
            width: 100%;
            height: 290px;
            background-color: #1f2430;
            overflow: hidden;
            position: relative;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .stock-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(14, 16, 21, 0.85);
            color: #00bac6;
            border: 1px solid #00bac6;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .stock-badge.out {
            color: #f87171;
            border-color: #f87171;
        }

        .product-body {
            padding: 22px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            margin: 0 0 6px;
            color: #ffffff;
        }

        .product-desc {
            color: #9ca3af;
            font-size: 0.92rem;
            line-height: 1.5;
            margin: 0 0 14px;
        }

        /* --- Tag Variasi Tersedia di Kartu Produk --- */
        .variation-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 16px;
            flex: 1;
            align-content: flex-start;
        }

        .var-tag {
            background-color: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #d1d5db;
            font-size: 0.76rem;
            padding: 3px 9px;
            border-radius: 6px;
        }

        .var-tag.sold {
            opacity: 0.45;
            text-decoration: line-through;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: #00bac6;
        }

        .product-weight {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .btn-buy {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(to right, #008080, #00bac6);
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn-buy:hover:not(:disabled) {
            opacity: 0.92;
            transform: translateY(-2px);
        }

        .btn-buy:disabled {
            background: #374151;
            color: #9ca3af;
            cursor: not-allowed;
        }

        /* --- Modal Pop-up Product Variations & Checkout --- */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.82);
            backdrop-filter: blur(6px);
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
        }

        .modal-box {
            background: #161922;
            border: 1px solid #00bac6;
            border-radius: 16px;
            width: 100%;
            max-width: 540px;
            padding: 28px;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            max-height: 92vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 20px;
            background: none;
            border: none;
            color: #9ca3af;
            font-size: 30px;
            cursor: pointer;
            line-height: 1;
        }

        .modal-close:hover {
            color: #ffffff;
        }

        .modal-header-info {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 16px;
            padding-right: 26px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header-info img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            background: #232836;
            flex-shrink: 0;
            border: 1px solid rgba(0, 186, 198, 0.4);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .modal-header-info h3 {
            margin: 0 0 4px;
            font-family: 'Syne', sans-serif;
            font-size: 1.35rem;
            line-height: 1.2;
        }

        .modal-product-desc {
            color: #9ca3af;
            font-size: 0.86rem;
            line-height: 1.45;
            margin: 0 0 8px;
        }

        .modal-header-info .modal-price {
            color: #00bac6;
            font-weight: 800;
            font-size: 1.15rem;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #d1d5db;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 11px 14px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background-color: #0e1015;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            outline: none;
        }

        .form-group select:focus,
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #00bac6;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .total-summary {
            background: rgba(0, 186, 198, 0.12);
            border: 1px solid rgba(0, 186, 198, 0.35);
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 16px 0 20px;
            font-weight: 700;
        }

        .total-summary span:last-child {
            color: #00bac6;
            font-size: 1.25rem;
        }

        footer {
            background: linear-gradient(to right, #1a1a1a 20%, #005f6b 65%, #008080 100%);
            color: #e5e7eb;
            text-align: center;
            padding: 28px 20px;
            font-size: 0.95rem;
        }

        @media (max-width: 700px) {
            header { padding: 14px 20px; }
            .nav-container { flex-direction: column; gap: 14px; }
            nav ul { gap: 16px; flex-wrap: wrap; justify-content: center; }
            .form-row-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header>
        <div class="nav-container">
            <a href="index.php" class="logo-link">
                <img src="Assets/images/CORTIS_Logo.jpg" alt="CORTIS Logo" class="nav-logo">
                <span class="logo-text">COERZONE</span>
            </a>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="About.php">About</a></li>
                    <li><a href="The_Music.php">#Stream Cortis</a></li>
                    <li><a href="Store.php" class="active">Support</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="store-hero">
        <h1>CORTIS Official Store</h1>
        <p>Support CORTIS with official merchandise, concert essentials, and exclusive album packages.</p>
    </section>

    <div class="store-container">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <div class="alert-banner alert-success">
                Order berhasil dibuat! Kode Transaksi Anda: <strong><?= htmlspecialchars($_GET['code'] ?? '-') ?></strong>. Terima kasih telah mendukung CORTIS!
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <div class="alert-banner alert-error">
                Gagal memproses pesanan: <?= htmlspecialchars($_GET['msg'] ?? 'Terjadi kesalahan pada input atau stok tidak mencukupi.') ?>
            </div>
        <?php endif; ?>

        <div class="products-grid">
            <?php if (!empty($products_list)) : ?>
                <?php foreach ($products_list as $p) : 
                    $pid         = (int) $p['product_id'];
                    $prod_img    = $p['resolved_image'];
                    $prod_desc   = $p['description'] ?? '';
                    $prod_vars   = $variations_by_product[$pid] ?? [];
                    $total_stock = $total_stock_by_product[$pid] ?? 0;
                    $vars_json   = htmlspecialchars(json_encode($prod_vars), ENT_QUOTES, 'UTF-8');
                ?>
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="<?= htmlspecialchars($prod_img) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>">
                        <?php if ($total_stock > 0) : ?>
                            <span class="stock-badge">Total Stok: <?= $total_stock ?></span>
                        <?php else : ?>
                            <span class="stock-badge out">Out of Stock</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-body">
                        <h3 class="product-title"><?= htmlspecialchars($p['product_name']) ?></h3>
                        <p class="product-desc"><?= htmlspecialchars($prod_desc) ?></p>

                        <!-- Ringkasan Variasi Produk -->
                        <div class="variation-tags">
                            <?php if (!empty($prod_vars)) : ?>
                                <?php foreach ($prod_vars as $pv) : ?>
                                    <span class="var-tag <?= ($pv['stock'] <= 0) ? 'sold' : '' ?>">
                                        <?= htmlspecialchars($pv['size']) ?> • <?= htmlspecialchars($pv['color']) ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <span class="var-tag">Belum ada variasi</span>
                            <?php endif; ?>
                        </div>

                        <div class="product-meta">
                            <span class="product-price">Rp <?= number_format((float)$p['price'], 0, ',', '.') ?></span>
                            <span class="product-weight"><?= (int)($p['weight_gram'] ?? 0) ?> gr</span>
                        </div>
                        <button type="button"
                                class="btn-buy"
                                <?= ($total_stock <= 0 || empty($prod_vars)) ? 'disabled' : '' ?>
                                onclick="openOrderModal(
                                    <?= $pid ?>,
                                    <?= htmlspecialchars(json_encode($p['product_name']), ENT_QUOTES, 'UTF-8') ?>,
                                    <?= htmlspecialchars(json_encode($prod_desc), ENT_QUOTES, 'UTF-8') ?>,
                                    <?= (float)$p['price'] ?>,
                                    <?= htmlspecialchars(json_encode($prod_img), ENT_QUOTES, 'UTF-8') ?>,
                                    <?= $vars_json ?>
                                )">
                            <?= ($total_stock > 0 && !empty($prod_vars)) ? 'BUY NOW' : 'SOLD OUT' ?>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p style="text-align:center; grid-column: 1 / -1; color:#9ca3af;">Belum ada produk yang tersedia di katalog.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- MODAL POP-UP PRODUCT VARIATIONS & CHECKOUT -->
    <div id="orderModal" class="modal-backdrop" onclick="if(event.target === this) closeOrderModal()">
        <div class="modal-box">
            <button type="button" class="modal-close" onclick="closeOrderModal()">&times;</button>

            <div class="modal-header-info">
                <img id="modalProductImg" src="" alt="Product">
                <div>
                    <h3 id="modalProductName">Product Name</h3>
                    <p class="modal-product-desc" id="modalProductDesc"></p>
                    <div class="modal-price" id="modalProductPrice">Rp 0</div>
                </div>
            </div>

            <form method="POST" action="proses_order.php">
                <input type="hidden" name="product_id" id="inputProductId">
                <input type="hidden" id="inputUnitPrice" value="0">

                <div class="form-group">
                    <label for="selectVariation">Pilih Variasi (Ukuran / Warna / Tipe)</label>
                    <select name="variation_id" id="selectVariation" required onchange="onVariationChange()"></select>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label for="inputQty">Jumlah Beli (Qty)</label>
                        <input type="number" name="quantity" id="inputQty" min="1" value="1" required oninput="updateTotalAmount()">
                    </div>
                    <div class="form-group">
                        <label for="selectPayment">Metode Pembayaran</label>
                        <select name="payment_method" id="selectPayment" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                            <option value="E-Wallet">E-Wallet (Dana / OVO / GoPay)</option>
                            <option value="COD">COD (Bayar di Tempat)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputCustomerName">Nama Lengkap Pembeli</label>
                    <input type="text" name="customer_name" id="inputCustomerName" placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label for="inputCustomerEmail">Email</label>
                        <input type="email" name="customer_email" id="inputCustomerEmail" placeholder="contoh@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="inputCustomerPhone">Nomor WhatsApp / HP</label>
                        <input type="text" name="customer_phone" id="inputCustomerPhone" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputShippingAddress">Alamat Lengkap Pengiriman</label>
                    <textarea name="shipping_address" id="inputShippingAddress" rows="2" placeholder="Jalan, Kelurahan, Kecamatan, Kota, Kode Pos" required></textarea>
                </div>

                <div class="total-summary">
                    <span>Total Pembayaran:</span>
                    <span id="displayTotalAmount">Rp 0</span>
                </div>

                <button type="submit" class="btn-buy">Konfirmasi & Buat Pesanan</button>
            </form>
        </div>
    </div>

    <footer>
        <p><em>Built with love by Fans, for Fans — always united for CORTIS.</em></p>
        <p>© 2026 Just Cortis | Unofficial fan-made website.</p>
    </footer>

    <script>
        let defaultProductImg = '';

        function formatRupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        function openOrderModal(productId, productName, productDesc, unitPrice, imgSrc, variations) {
            defaultProductImg = imgSrc;
            document.getElementById('inputProductId').value = productId;
            document.getElementById('inputUnitPrice').value = unitPrice;
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductDesc').textContent = productDesc;
            document.getElementById('modalProductPrice').textContent = formatRupiah(unitPrice);
            document.getElementById('modalProductImg').src = imgSrc;

            const selectVar = document.getElementById('selectVariation');
            selectVar.innerHTML = '';

            let firstAvailableIdx = -1;
            variations.forEach(function(v, index) {
                const opt = document.createElement('option');
                opt.value = v.variation_id;
                opt.dataset.stock = v.stock;
                opt.dataset.image = v.image_path || imgSrc;
                opt.textContent = v.size + ' - ' + v.color + ' (' + v.gender_type + ') | Stok: ' + v.stock;
                if (v.stock <= 0) {
                    opt.disabled = true;
                } else if (firstAvailableIdx === -1) {
                    firstAvailableIdx = index;
                }
                selectVar.appendChild(opt);
            });

            if (firstAvailableIdx !== -1) {
                selectVar.selectedIndex = firstAvailableIdx;
            }

            document.getElementById('inputQty').value = 1;
            onVariationChange();
            document.getElementById('orderModal').style.display = 'flex';
        }

        function closeOrderModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

        function onVariationChange() {
            const selectVar = document.getElementById('selectVariation');
            const selectedOpt = selectVar.options[selectVar.selectedIndex];
            const qtyInput = document.getElementById('inputQty');
            const modalImg = document.getElementById('modalProductImg');

            if (selectedOpt) {
                if (selectedOpt.dataset.image) {
                    modalImg.src = selectedOpt.dataset.image;
                } else {
                    modalImg.src = defaultProductImg;
                }

                if (selectedOpt.dataset.stock) {
                    const maxStock = parseInt(selectedOpt.dataset.stock, 10);
                    qtyInput.max = maxStock;
                    if (parseInt(qtyInput.value, 10) > maxStock) {
                        qtyInput.value = maxStock > 0 ? maxStock : 1;
                    }
                }
            }
            updateTotalAmount();
        }

        function updateTotalAmount() {
            const unitPrice = parseFloat(document.getElementById('inputUnitPrice').value) || 0;
            const qty = parseInt(document.getElementById('inputQty').value, 10) || 1;
            document.getElementById('displayTotalAmount').textContent = formatRupiah(unitPrice * qty);
        }
    </script>

</body>
</html>