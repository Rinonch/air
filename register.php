<?php
session_start();
include './assets/func.php';
$air = new klas_air;
$koneksi = $air->koneksi();

$pesan = "";
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $nama     = trim($_POST['nama']);
    $alamat   = trim($_POST['alamat']);
    $kota     = trim($_POST['kota']);
    $telp     = trim($_POST['telp']);
    $tipe     = isset($_POST['tipe']) ? $_POST['tipe'] : '-'; // Tambah tipe

    // Cek username sudah ada
    $cek = mysqli_query($koneksi, "SELECT username FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = '<div class="alert alert-danger">Username sudah terdaftar!</div>';
    } else {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $q = mysqli_query($koneksi, "INSERT INTO user (username, password, nama, alamat, kota, telp, level, tipe, status) VALUES ('$username', '$pass_hash', '$nama', '$alamat', '$kota', '$telp', 'warga', '$tipe', 'AKTIF')");
        if ($q) {
            $pesan = '<div class="alert alert-success">Registrasi berhasil! <a href="index.php">Login di sini</a></div>';
        } else {
            $pesan = '<div class="alert alert-danger">Registrasi gagal!</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register - Hydropay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="./css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body.bg-primary {
            background: radial-gradient(circle at 20% 30%, #21cbf3 0%, #1976d2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            /* Tambahkan padding bawah agar tidak mepet footer */
            padding-bottom: 60px;
        }
        .card {
            border: none;
            border-radius: 2rem;
            box-shadow: 0 12px 48px 0 rgba(33, 203, 243, 0.15), 0 1.5px 8px 0 rgba(25, 118, 210, 0.10);
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(6px);
            transition: box-shadow 0.2s, transform 0.2s;
            padding-bottom: 0.5rem;
            margin-top: 48px;      /* Tambah jarak dari atas */
            margin-bottom: 48px;   /* Tambah jarak dari bawah */
        }
        .card-header {
            background: transparent;
            border-bottom: none;
            margin-bottom: -10px;
        }
        .card-header h3 {
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #1976d2;
            font-size: 2.1rem;
            text-shadow: 0 2px 8px #21cbf344;
        }
        .form-control, .form-select {
            border-radius: 1.2rem;
            border: 1.5px solid #e3e3e3;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 1.13rem;
            padding: 0.85rem 1.1rem;
            background: rgba(255,255,255,0.95);
        }
        .form-control:focus, .form-select:focus {
            border-color: #21cbf3;
            box-shadow: 0 0 0 0.2rem rgba(33,203,243,.13);
        }
        .btn-primary {
            background: linear-gradient(90deg, #1976d2 0%, #21cbf3 100%);
            border: none;
            border-radius: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            box-shadow: 0 2px 12px 0 rgba(33,203,243,.13);
            padding: 0.6rem 2.2rem;
            font-size: 1.1rem;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(90deg, #21cbf3 0%, #1976d2 100%);
            box-shadow: 0 4px 20px 0 rgba(33,203,243,.18);
            transform: translateY(-2px) scale(1.03);
        }
        .card-footer {
            background: transparent;
            border-top: none;
        }
        .small a {
            color: #1976d2;
            font-weight: 500;
            transition: color 0.2s;
        }
        .small a:hover {
            color: #21cbf3;
            text-decoration: underline;
        }
        .d-grid {
            margin-bottom: 0.5rem;
        }
        .text-center.mb-2 {
            margin-bottom: 0.5rem !important;
        }
        @media (max-width: 576px) {
            .card {
                margin-top: 1.5rem !important;
                margin-bottom: 1.5rem !important;
                border-radius: 1.1rem;
                padding-bottom: 0;
            }
            .col-lg-5 {
                padding: 0;
            }
            .card-header h3 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Register Hydropay</h3></div>
                                <div class="card-body">
                                    <?php if ($pesan) echo $pesan; ?>
                                    <form method="POST" class="needs-validation">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputNama" type="text" placeholder="Nama Lengkap" name="nama" required />
                                            <label for="inputNama">Nama Lengkap</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUser" type="text" placeholder="Username" name="username" required />
                                            <label for="inputUser">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputAlamat" type="text" placeholder="Alamat" name="alamat" required />
                                            <label for="inputAlamat">Alamat</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputKota" type="text" placeholder="Kota" name="kota" required />
                                            <label for="inputKota">Kota</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputTelp" type="text" placeholder="No. Telepon" name="telp" required />
                                            <label for="inputTelp">No. Telepon</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="inputTipe" name="tipe" required>
                                                <option value="" disabled selected> - </option>
                                                <option value="Rumah">Rumah</option>
                                                <option value="Kost">Kost</option>
                                            </select>
                                            <label for="inputTipe">Tipe</label>
                                        </div>
                                        <div class="d-grid gap-2 mt-4 mb-2">
                                            <input type="submit" name="register" value="Register" class="btn btn-primary btn-lg" />
                                        </div>
                                        <div class="text-center mb-2">
                                            <a class="small" href="index.php">Sudah punya akun? Login!</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="index.php">Kembali ke Login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website <?php echo date("Y")?></div>
                        <div>
                            <a href="./profile/profile.html">Profile</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./js/scripts.js"></script>
</body>
</html>