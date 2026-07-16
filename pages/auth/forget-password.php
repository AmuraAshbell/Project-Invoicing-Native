<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Amura Store</title>
    
    <link rel="stylesheet" href="../../style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css"/>
    
    <style>
        /* Memastikan background menutupi seluruh layar dan posisi box ada di tengah */
        body.login-page {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f6f9; /* Warna default light mode AdminLTE */
        }
        .login-box {
            width: 400px;
            max-width: 90%;
        }
    </style>
</head>
<body class="login-page bg-body-secondary app-wrapper">
    
    <div class="login-box">
        <div class="login-logo text-center mb-4">
            <a href="#" class="text-decoration-none text-body fw-bold fs-3"><b>Amura</b>Store</a>
        </div>
        
        <div class="card card-outline card-primary shadow">
            <div class="card-body login-card-body p-4">
                <p class="login-box-msg text-center mb-4 text-muted">
                    Lupa password Anda? Masukkan alamat email yang terdaftar untuk menerima tautan reset password.
                </p>

                <form action="proses-reset.php" method="POST">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email Terdaftar" required>
                        <div class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 fw-bold">
                                Kirim Link Reset
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mt-4 mb-0 text-center">
                    <a href="login.php" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Login
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../dist/js/adminlte.js"></script>

    <script>
      (() => {
        'use strict';
        const STORAGE_KEY = 'lte-theme';
        const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
        const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);
        const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;
        const getPreferredTheme = () => {
          const stored = getStoredTheme();
          if (stored) return stored;
          return prefersDark() ? 'dark' : 'light';
        };
        const setTheme = (theme) => {
          const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme;
          document.documentElement.setAttribute('data-bs-theme', resolved);
        };
        setTheme(getPreferredTheme());
        globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
          const stored = getStoredTheme();
          if (!stored || stored === 'auto') setTheme(getPreferredTheme());
        });
      })();
    </script>
</body>
</html>