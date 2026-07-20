<?php
session_start();
require_once __DIR__ . '/../../config/app.php';

// Jika sudah login, tendang ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/modules/dashboard/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAC - Login Sistem</title>
    
    <!-- Google Fonts: Plus Jakarta Sans (Modern Sans) & Playfair Display (Elegant Serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    
    <style>
        :root {
            --primary-color: #3b6f58;
            --primary-hover: #2e5846;
            --bg-light: #f8fafc;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Serif Font Class */
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* Split Screen Setup */
        .login-container {
            min-height: 100vh;
        }

        /* Left Side: 3D Abstract Geometric Background */
        .split-left {
            /* Menggunakan gambar 3D geometric high-end dari Unsplash sebagai placeholder */
            background: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat;
            position: relative;
        }
        
        /* Soft overlay agar gambar 3D menyatu dengan tema hijau pondok */
        .split-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(59, 111, 88, 0.7) 0%, rgba(15, 23, 42, 0.8) 100%);
        }

        .split-left-content {
            position: relative;
            z-index: 1;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            color: white;
        }

        /* Right Side: Minimalist Form Container */
        .split-right {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .form-wrapper {
            width: 100%;
            max-width: 440px;
            padding: 3rem 2rem;
        }

        /* Input Styling: Soft drop shadows, modern digital product showcase */
        .form-control-custom {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem; /* rounded-xl */
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            background-color: #f8fafc;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.02);
        }

        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 111, 88, 0.15), 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            outline: none;
        }

        /* Form Label */
        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            letter-spacing: 0.025em;
        }

        /* Button Styling */
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 1rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(59, 111, 88, 0.39);
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 111, 88, 0.4);
            color: white;
        }

        .logo-login {
            height: 90px;
            width: auto;
            object-fit: contain;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }
    </style>
</head>
<body>

    <div class="container-fluid login-container p-0">
        <div class="row g-0 h-100">
            
            <!-- LEFT SIDE: 3D Abstract & Branding (Hidden on mobile) -->
            <div class="col-lg-7 d-none d-lg-block split-left">
                <div class="split-left-content">
                    <div style="max-width: 500px;">
                        <h1 class="font-serif fw-bold mb-3" style="font-size: 3.5rem; line-height: 1.2;">Inovasi<br>Administrasi<br>Modern.</h1>
                        <p class="fs-5 opacity-75 fw-light" style="line-height: 1.6;">
                            Platform terintegrasi untuk pengelolaan data santri, alumni, dan tenaga pendidik secara *real-time* dan efisien.
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Minimalist Form Container -->
            <div class="col-lg-5 split-right">
                <div class="form-wrapper">
                    
                    <div class="text-center mb-5">
                        <!-- LOGO PPAC -->
                        <img src="<?= BASE_URL ?>/assets/logo-ppac.png" alt="Logo PPAC" class="logo-login">
                        
                        <!-- TITLE & SUBTITLE -->
                        <h2 class="font-serif fw-bold text-dark mb-1" style="font-size: 2.2rem; letter-spacing: -0.02em;">SIAC</h2>
                        <p class="text-muted fw-medium" style="font-size: 0.95rem; letter-spacing: 0.05em; text-transform: uppercase;">
                            Sistem Informasi Asma Chusna
                        </p>
                    </div>
                    
                    <form id="loginForm">
                        <div class="mb-4">
                            <label class="form-label-custom">Username</label>
                            <input type="text" name="username" class="form-control-custom w-100" placeholder="Masukkan username admin" required autocomplete="off">
                        </div>
                        <div class="mb-5">
                            <label class="form-label-custom">Password</label>
                            <input type="password" name="password" class="form-control-custom w-100" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-login w-100 d-flex justify-content-center align-items-center gap-2" id="btnLogin">
                            <span>Masuk ke Sistem</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                            </svg>
                        </button>
                    </form>

                    <div class="text-center mt-5">
                        <p class="text-muted small mb-0">&copy; <?= date('Y') ?> Pondok Pesantren Asma' Chusna.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btnLogin = document.getElementById('btnLogin');
            const originalBtnHtml = btnLogin.innerHTML;
            btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span class="ms-2">Memverifikasi...</span>';
            btnLogin.disabled = true;

            const formData = new FormData(this);

            fetch('login_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Akses Diberikan',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: { popup: 'rounded-4' }
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Akses Ditolak',
                        text: data.message,
                        confirmButtonColor: '#3b6f58',
                        customClass: { popup: 'rounded-4' }
                    });
                    btnLogin.innerHTML = originalBtnHtml;
                    btnLogin.disabled = false;
                }
            })
            .catch(error => {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error Server', 
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    customClass: { popup: 'rounded-4' }
                });
                btnLogin.innerHTML = originalBtnHtml;
                btnLogin.disabled = false;
            });
        });
    </script>
</body>
</html>