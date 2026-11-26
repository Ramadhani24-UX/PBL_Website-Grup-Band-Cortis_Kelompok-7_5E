<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_cortis";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Tangkap seluruh output di folder Admin/ tanpa terhalang level buffer bawaan Laragon
$current_script_dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME'] ?? ''));
if (preg_match('#/admin$#i', $current_script_dir)) {
    ob_start(function ($output) {
        $has_alert = false;
        $output = preg_replace_callback(
            '/<script>\s*alert\(([\'"])(.*?)\1\);\s*(?:window\.location\s*=\s*([\'"])(.*?)\3;)?\s*<\/script>/is',
            function ($m) use (&$has_alert) {
                $has_alert = true;
                $raw_msg   = stripcslashes($m[2]);
                $redirect  = $m[4] ?? '';
                $is_error  = (stripos($raw_msg, 'error') !== false || stripos($raw_msg, 'fail') !== false || stripos($raw_msg, 'gagal') !== false);
                $icon      = $is_error ? 'error' : 'success';
                $title     = $is_error ? 'Terjadi Kesalahan!' : 'Berhasil!';

                $js_msg    = json_encode($raw_msg);
                $js_redir  = json_encode($redirect);

                if ($redirect !== '') {
                    return "<script>
                        window.addEventListener('load', function() {
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
                        window.addEventListener('load', function() {
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
            $output
        );

        // Bungkus dengan HTML gelap + SweetAlert2 jika halaman hanya berisi script (seperti *_delete.php)
        if ($has_alert && stripos($output, '<html') === false) {
            $output = '<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORTIS Admin Notification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css">
    <style>
        body { background-color: #0e1015; margin: 0; font-family: sans-serif; }
        .swal2-popup { background: #161922 !important; border: 1px solid rgba(0, 186, 198, 0.4) !important; border-radius: 14px !important; }
        .swal2-title, .swal2-html-container { color: #ffffff !important; }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    ' . $output . '
</body>
</html>';
        }

        return $output;
    });
}
?>