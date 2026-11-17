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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = Array.from(form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled])'));
        
        inputs.forEach((input, index) => {
            // 1. Pindah kolom saat menekan Enter (kecuali input paling akhir)
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && input.tagName.toLowerCase() !== 'textarea') {
                    if (index < inputs.length - 1) {
                        e.preventDefault();
                        inputs[index + 1].focus();
                    }
                }
            });

            // 2. Sesuaikan pesan peringatan merah secara otomatis sesuai nama kolom/perintah masing-masing
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

                // Ubah teks merah bawaan Bootstrap (.invalid-feedback) & tooltip browser
                if (feedbackEl) {
                    feedbackEl.textContent = customMsg;
                }
                if (!input.validity.valid) {
                    input.setCustomValidity(customMsg);
                } else {
                    input.setCustomValidity('');
                }
            };

            // Jalankan saat gagal validasi (invalid) dan bersihkan otomatis saat user mulai mengetik/memilih
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