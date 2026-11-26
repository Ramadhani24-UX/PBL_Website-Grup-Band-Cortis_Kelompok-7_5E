</div> <!-- Penutup container-fluid -->
        </div> <!-- Penutup app-content -->
    </main> <!-- Penutup app-main -->

    <!-- FOOTER ADMINLTE -->
    <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">CORTIS Core System</div>
        <strong>Copyright &copy; 2026 <a href="#" class="text-accent text-decoration-none">AdminLTE</a>.</strong> All rights reserved.
    </footer>

</div> <!-- Penutup app-wrapper -->

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS AdminLTE v4 -->
<script src="adminlte/js/adminlte.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Ubah seluruh dialog confirm() bawaan browser (Delete & Logout) menjadi SweetAlert2
    document.querySelectorAll('a[onclick*="confirm("]').forEach(function (link) {
        const onclickAttr = link.getAttribute('onclick') || '';
        const match = onclickAttr.match(/confirm\((['"])(.*?)\1\)/);
        const message = match ? match[2] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

        link.removeAttribute('onclick');
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetUrl = this.getAttribute('href');
            const isLogout = targetUrl.includes('logout.php');

            Swal.fire({
                title: isLogout ? 'Konfirmasi Logout' : 'Hapus Data?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#4b5563',
                confirmButtonText: isLogout ? 'Ya, Keluar' : 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = targetUrl;
                }
            });
        });
    });

    // 2. Fitur pindah kolom dengan Enter & pesan validasi form otomatis
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = Array.from(form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled])'));
        
        inputs.forEach((input, index) => {
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && input.tagName.toLowerCase() !== 'textarea') {
                    if (index < inputs.length - 1) {
                        e.preventDefault();
                        inputs[index + 1].focus();
                    }
                }
            });

            const wrapper = input.closest('.mb-3, .form-group, div');
            const labelEl = wrapper ? wrapper.querySelector('label') : null;
            const fieldName = labelEl ? labelEl.textContent.replace('*', '').trim() : (input.name || 'kolom ini');
            const feedbackEl = wrapper ? wrapper.querySelector('.invalid-feedback') : null;

            const setCustomAlertMessage = () => {
                let customMsg = `Kolom "${fieldName}" wajib diisi.`;
                
                if (input.type === 'date') {
                    customMsg = `Silakan pilih tanggal untuk ${fieldName}.`;
                } else if (input.type === 'number') {
                    customMsg = `Masukkan angka yang valid untuk ${fieldName}.`;
                } else if (input.type === 'file') {
                    customMsg = `Silakan unggah file untuk ${fieldName}.`;
                } else if (input.tagName.toLowerCase() === 'select') {
                    customMsg = `Silakan pilih salah satu opsi pada ${fieldName}.`;
                }

                if (feedbackEl) {
                    feedbackEl.textContent = customMsg;
                }
                if (!input.validity.valid) {
                    input.setCustomValidity(customMsg);
                } else {
                    input.setCustomValidity('');
                }
            };

            input.addEventListener('invalid', setCustomAlertMessage);
            input.addEventListener('input', function () {
                input.setCustomValidity('');
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                }
            });
            input.addEventListener('change', function () {
                input.setCustomValidity('');
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid');
                }
            });
        });
    });
});
</script>
</body>
</html>
<?php
// Tangkap output buffer dan ganti seluruh alert() bawaan browser menjadi SweetAlert2
$page_output = ob_get_clean();

$page_output = preg_replace_callback(
    '/<script>\s*alert\(([\'"])(.*?)\1\);\s*(?:window\.location\s*=\s*([\'"])(.*?)\3;)?\s*<\/script>/is',
    function ($m) {
        $raw_msg  = stripcslashes($m[2]);
        $redirect = $m[4] ?? '';
        $is_error = (stripos($raw_msg, 'error') !== false || stripos($raw_msg, 'fail') !== false || stripos($raw_msg, 'gagal') !== false);
        $icon     = $is_error ? 'error' : 'success';
        $title    = $is_error ? 'Terjadi Kesalahan!' : 'Berhasil!';

        $js_msg   = json_encode($raw_msg);
        $js_redir = json_encode($redirect);

        if ($redirect !== '') {
            return "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: '$icon',
                        title: '$title',
                        text: $js_msg,
                        confirmButtonColor: '#00bac6',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href = $js_redir;
                    });
                });
            </script>";
        } else {
            return "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: '$icon',
                        title: '$title',
                        text: $js_msg,
                        confirmButtonColor: '#00bac6',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
    },
    $page_output
);

echo $page_output;
?>